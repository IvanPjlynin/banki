<?php

namespace AcyMailing\Helpers;

use AcyMailing\Classes\MailClass;
use AcyMailing\Controllers\SegmentsController;
use AcyMailing\Libraries\acymObject;

class AutomationHelper extends acymObject
{
    var $from = ' `#__acym_user` AS `user`';
    var $leftjoin = [];
    var $join = [];
    var $where = [];
    var $orderBy = '';
    var $groupBy = '';
    var $limit = '';

    public function getQuery($select = [])
    {
        $query = '';
        if (!empty($select)) $query .= ' SELECT DISTINCT '.implode(',', $select);
        if (!empty($this->from)) $query .= ' FROM '.$this->from;
        if (!empty($this->join)) $query .= ' JOIN '.implode(' JOIN ', $this->join);
        if (!empty($this->leftjoin)) $query .= ' LEFT JOIN '.implode(' LEFT JOIN ', $this->leftjoin);
        if (!empty($this->where)) $query .= ' WHERE ('.implode(') AND (', $this->where).')';
        if (!empty($this->groupBy)) $query .= ' GROUP BY '.$this->groupBy;
        if (!empty($this->orderBy)) $query .= ' ORDER BY '.$this->orderBy;
        if (!empty($this->limit)) $query .= ' LIMIT '.$this->limit;

        return $query;
    }

    public function count()
    {
        return acym_loadResult($this->getQuery(['COUNT(DISTINCT user.id)']));
    }

    public function addFlag($id, $reset = false)
    {
        if (!empty($this->orderBy) || !empty($this->limit)) {
            $flagQuery = 'UPDATE #__acym_user';
            $flagQuery .= ' SET automation = CONCAT(automation, "a'.intval($id).'a")';
            $flagQuery .= ' WHERE id IN (
			SELECT id FROM (SELECT user.id FROM #__acym_user AS user';
            if (!empty($this->join)) $flagQuery .= ' JOIN '.implode(' JOIN ', $this->join);
            if (!empty($this->leftjoin)) $flagQuery .= ' LEFT JOIN '.implode(' LEFT JOIN ', $this->leftjoin);
            if (!empty($this->where)) $flagQuery .= ' WHERE ('.implode(') AND (', $this->where).')';
            if (!empty($this->orderBy)) $flagQuery .= ' ORDER BY '.$this->orderBy;
            if (!empty($this->limit)) $flagQuery .= ' LIMIT '.$this->limit;
            $flagQuery .= ') tmp);';
        } else {
            $flagQuery = 'UPDATE #__acym_user AS user ';
            if (!empty($this->join)) $flagQuery .= ' JOIN '.implode(' JOIN ', $this->join);
            if (!empty($this->leftjoin)) $flagQuery .= ' LEFT JOIN '.implode(' LEFT JOIN ', $this->leftjoin);
            $flagQuery .= ' SET user.automation = CONCAT(user.automation, "a'.intval($id).'a")';
            if (!empty($this->where)) $flagQuery .= ' WHERE ('.implode(') AND (', $this->where).')';
        }
        acym_query($flagQuery);

        $this->join = [];
        $this->leftjoin = [];
        $this->where = $reset ? [] : ['user.automation LIKE "%a'.intval($id).'a%"'];
        $this->orderBy = '';
        $this->limit = '';
    }

    public function removeFlag($id = null)
    {
        if (is_null($id)) {
            $segmentsController = new SegmentsController();
            $id = $segmentsController::FLAG_USERS;
        }
        acym_query('UPDATE #__acym_user SET automation = REPLACE(automation, "a'.intval($id).'a", "") WHERE automation LIKE "%a'.intval($id).'a%"');
    }

    public function convertQuery($table, $column, $operator, $value, $type = '')
    {
        $operator = str_replace(['&lt;', '&gt;'], ['<', '>'], $operator);

        if ($operator == 'CONTAINS' || ($type == 'phone' && $operator == '=')) {
            $operator = 'LIKE';
            $value = '%'.$value.'%';
        } elseif ($operator == 'BEGINS') {
            $operator = 'LIKE';
            $value = $value.'%';
        } elseif ($operator == 'END') {
            $operator = 'LIKE';
            $value = '%'.$value;
        } elseif ($operator == 'NOTCONTAINS' || ($type == 'phone' && $operator == '!=')) {
            $operator = 'NOT LIKE';
            $value = '%'.$value.'%';
        } elseif ($operator == 'REGEXP') {
            if ($value === '') return '1 = 1';
        } elseif ($operator == 'NOT REGEXP') {
            if ($value === '') return '0 = 1';
        } elseif (!in_array($operator, ['IS NULL', 'IS NOT NULL', 'NOT LIKE', 'LIKE', '=', '!=', '>', '<', '>=', '<='])) {
            die(acym_translationSprintf('ACYM_UNKNOWN_OPERATOR', $operator));
        }

        if (strpos($value, '[time]') !== false) {
            $value = acym_replaceDate($value);
            $value = strftime('%Y-%m-%d %H:%M:%S', $value);
        }

        $value = acym_replaceDateTags($value);

        if (!is_numeric($value) || in_array($operator, ['REGEXP', 'NOT REGEXP', 'NOT LIKE', 'LIKE', '=', '!='])) {
            $value = acym_escapeDB($value);
        }

        if (in_array($operator, ['IS NULL', 'IS NOT NULL'])) {
            $value = '';
        }

        if (!empty($table)) $table = acym_secureDBColumn($table).'.';
        if ($type == 'datetime' && in_array($operator, ['=', '!='])) {
            return 'DATE_FORMAT('.$table.'`'.acym_secureDBColumn($column).'`, "%Y-%m-%d") '.$operator.' '.'DATE_FORMAT('.$value.', "%Y-%m-%d")';
        }
        if ($type == 'timestamp' && in_array($operator, ['=', '!='])) {
            return 'FROM_UNIXTIME('.$table.'`'.acym_secureDBColumn($column).'`, "%Y-%m-%d") '.$operator.' '.'FROM_UNIXTIME('.$value.', "%Y-%m-%d")';
        }

        return $table.'`'.acym_secureDBColumn($column).'` '.$operator.' '.$value;
    }

    public function deleteUnusedEmails()
    {
        $automationEmails = acym_loadResultArray('SELECT id FROM #__acym_mail WHERE type = "automation"');

        $emailsToDelete = [];
        foreach ($automationEmails as $email) {
            $search = '"acy_add_queue":{"mail_id":"'.$email.'"';
            $action = acym_loadResult('SELECT id FROM #__acym_action WHERE actions LIKE '.acym_escapeDB('%'.$search.'%'));

            if (empty($action)) $emailsToDelete[] = $email;
        }

        if (!empty($emailsToDelete)) {
            $mailClass = new MailClass();
            $mailClass->delete($emailsToDelete);
        }
    }
}
