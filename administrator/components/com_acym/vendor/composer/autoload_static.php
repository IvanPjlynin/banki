<?php


namespace Composer\Autoload;

class ComposerStaticInit621c9c90031d23133d364b119f138ba8
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AcyMailing\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AcyMailing\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'AcyMailing\\Classes\\ActionClass' => __DIR__ . '/../..' . '/classes/action.php',
        'AcyMailing\\Classes\\AutomationClass' => __DIR__ . '/../..' . '/classes/automation.php',
        'AcyMailing\\Classes\\CampaignClass' => __DIR__ . '/../..' . '/classes/campaign.php',
        'AcyMailing\\Classes\\ConditionClass' => __DIR__ . '/../..' . '/classes/condition.php',
        'AcyMailing\\Classes\\ConfigurationClass' => __DIR__ . '/../..' . '/classes/configuration.php',
        'AcyMailing\\Classes\\FieldClass' => __DIR__ . '/../..' . '/classes/field.php',
        'AcyMailing\\Classes\\FollowupClass' => __DIR__ . '/../..' . '/classes/followup.php',
        'AcyMailing\\Classes\\FormClass' => __DIR__ . '/../..' . '/classes/form.php',
        'AcyMailing\\Classes\\HistoryClass' => __DIR__ . '/../..' . '/classes/history.php',
        'AcyMailing\\Classes\\ListClass' => __DIR__ . '/../..' . '/classes/list.php',
        'AcyMailing\\Classes\\MailClass' => __DIR__ . '/../..' . '/classes/mail.php',
        'AcyMailing\\Classes\\MailStatClass' => __DIR__ . '/../..' . '/classes/mailstat.php',
        'AcyMailing\\Classes\\MailpoetClass' => __DIR__ . '/../..' . '/classes/mailpoet.php',
        'AcyMailing\\Classes\\OverrideClass' => __DIR__ . '/../..' . '/classes/override.php',
        'AcyMailing\\Classes\\PluginClass' => __DIR__ . '/../..' . '/classes/plugin.php',
        'AcyMailing\\Classes\\QueueClass' => __DIR__ . '/../..' . '/classes/queue.php',
        'AcyMailing\\Classes\\RuleClass' => __DIR__ . '/../..' . '/classes/rule.php',
        'AcyMailing\\Classes\\SegmentClass' => __DIR__ . '/../..' . '/classes/segment.php',
        'AcyMailing\\Classes\\StepClass' => __DIR__ . '/../..' . '/classes/step.php',
        'AcyMailing\\Classes\\TagClass' => __DIR__ . '/../..' . '/classes/tag.php',
        'AcyMailing\\Classes\\UrlClass' => __DIR__ . '/../..' . '/classes/url.php',
        'AcyMailing\\Classes\\UrlClickClass' => __DIR__ . '/../..' . '/classes/urlclick.php',
        'AcyMailing\\Classes\\UserClass' => __DIR__ . '/../..' . '/classes/user.php',
        'AcyMailing\\Classes\\UserStatClass' => __DIR__ . '/../..' . '/classes/userstat.php',
        'AcyMailing\\Controllers\\AutomationController' => __DIR__ . '/../..' . '/controllers/automation.php',
        'AcyMailing\\Controllers\\BouncesController' => __DIR__ . '/../..' . '/controllers/bounces.php',
        'AcyMailing\\Controllers\\CampaignsController' => __DIR__ . '/../..' . '/controllers/campaigns.php',
        'AcyMailing\\Controllers\\ConfigurationController' => __DIR__ . '/../..' . '/controllers/configuration.php',
        'AcyMailing\\Controllers\\DashboardController' => __DIR__ . '/../..' . '/controllers/dashboard.php',
        'AcyMailing\\Controllers\\DeactivateController' => __DIR__ . '/../..' . '/controllers/deactivate.php',
        'AcyMailing\\Controllers\\DynamicsController' => __DIR__ . '/../..' . '/controllers/dynamics.php',
        'AcyMailing\\Controllers\\EntitySelectController' => __DIR__ . '/../..' . '/controllers/entitySelect.php',
        'AcyMailing\\Controllers\\FieldsController' => __DIR__ . '/../..' . '/controllers/fields.php',
        'AcyMailing\\Controllers\\FileController' => __DIR__ . '/../..' . '/controllers/file.php',
        'AcyMailing\\Controllers\\FollowupsController' => __DIR__ . '/../..' . '/controllers/followups.php',
        'AcyMailing\\Controllers\\FormsController' => __DIR__ . '/../..' . '/controllers/forms.php',
        'AcyMailing\\Controllers\\GoproController' => __DIR__ . '/../..' . '/controllers/gopro.php',
        'AcyMailing\\Controllers\\LanguageController' => __DIR__ . '/../..' . '/controllers/language.php',
        'AcyMailing\\Controllers\\ListsController' => __DIR__ . '/../..' . '/controllers/lists.php',
        'AcyMailing\\Controllers\\MailsController' => __DIR__ . '/../..' . '/controllers/mails.php',
        'AcyMailing\\Controllers\\OverrideController' => __DIR__ . '/../..' . '/controllers/override.php',
        'AcyMailing\\Controllers\\PluginsController' => __DIR__ . '/../..' . '/controllers/plugins.php',
        'AcyMailing\\Controllers\\QueueController' => __DIR__ . '/../..' . '/controllers/queue.php',
        'AcyMailing\\Controllers\\SegmentsController' => __DIR__ . '/../..' . '/controllers/segments.php',
        'AcyMailing\\Controllers\\StatsController' => __DIR__ . '/../..' . '/controllers/stats.php',
        'AcyMailing\\Controllers\\ToggleController' => __DIR__ . '/../..' . '/controllers/toggle.php',
        'AcyMailing\\Controllers\\UpdateController' => __DIR__ . '/../..' . '/controllers/update.php',
        'AcyMailing\\Controllers\\UsersController' => __DIR__ . '/../..' . '/controllers/users.php',
        'AcyMailing\\FrontControllers\\ArchiveController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/archive.php',
        'AcyMailing\\FrontControllers\\CronController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/cron.php',
        'AcyMailing\\FrontControllers\\FrontcampaignsController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontcampaigns.php',
        'AcyMailing\\FrontControllers\\FrontdynamicsController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontdynamics.php',
        'AcyMailing\\FrontControllers\\FrontentityselectController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontentityselect.php',
        'AcyMailing\\FrontControllers\\FrontfileController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontfile.php',
        'AcyMailing\\FrontControllers\\FrontlistsController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontlists.php',
        'AcyMailing\\FrontControllers\\FrontmailsController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontmails.php',
        'AcyMailing\\FrontControllers\\FrontstatsController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontstats.php',
        'AcyMailing\\FrontControllers\\FronttoggleController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/fronttoggle.php',
        'AcyMailing\\FrontControllers\\FronturlController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/fronturl.php',
        'AcyMailing\\FrontControllers\\FrontusersController' => __DIR__ . '/../..' . '/../../../components/com_acym/controllers/frontusers.php',
        'AcyMailing\\FrontViews\\ArchiveViewArchive' => __DIR__ . '/../..' . '/../../../components/com_acym/views/archive/view.html.php',
        'AcyMailing\\FrontViews\\FrontcampaignsViewFrontcampaigns' => __DIR__ . '/../..' . '/../../../components/com_acym/views/frontcampaigns/view.html.php',
        'AcyMailing\\FrontViews\\FrontdynamicsViewFrontdynamics' => __DIR__ . '/../..' . '/../../../components/com_acym/views/frontdynamics/view.html.php',
        'AcyMailing\\FrontViews\\FrontfileViewFrontfile' => __DIR__ . '/../..' . '/../../../components/com_acym/views/frontfile/view.html.php',
        'AcyMailing\\FrontViews\\FrontlistsViewFrontlists' => __DIR__ . '/../..' . '/../../../components/com_acym/views/frontlists/view.html.php',
        'AcyMailing\\FrontViews\\FrontmailsViewFrontmails' => __DIR__ . '/../..' . '/../../../components/com_acym/views/frontmails/view.html.php',
        'AcyMailing\\FrontViews\\FrontusersViewFrontusers' => __DIR__ . '/../..' . '/../../../components/com_acym/views/frontusers/view.html.php',
        'AcyMailing\\Helpers\\AutomationHelper' => __DIR__ . '/../..' . '/helpers/automation.php',
        'AcyMailing\\Helpers\\BounceHelper' => __DIR__ . '/../..' . '/helpers/bounce.php',
        'AcyMailing\\Helpers\\CaptchaHelper' => __DIR__ . '/../..' . '/helpers/captcha.php',
        'AcyMailing\\Helpers\\CronHelper' => __DIR__ . '/../..' . '/helpers/cron.php',
        'AcyMailing\\Helpers\\EditorHelper' => __DIR__ . '/../..' . '/helpers/editor.php',
        'AcyMailing\\Helpers\\EncodingHelper' => __DIR__ . '/../..' . '/helpers/encoding.php',
        'AcyMailing\\Helpers\\EntitySelectHelper' => __DIR__ . '/../..' . '/helpers/entitySelect.php',
        'AcyMailing\\Helpers\\ExportHelper' => __DIR__ . '/../..' . '/helpers/export.php',
        'AcyMailing\\Helpers\\FormPositionHelper' => __DIR__ . '/../..' . '/helpers/formposition.php',
        'AcyMailing\\Helpers\\HeaderHelper' => __DIR__ . '/../..' . '/helpers/header.php',
        'AcyMailing\\Helpers\\ImageHelper' => __DIR__ . '/../..' . '/helpers/image.php',
        'AcyMailing\\Helpers\\ImportHelper' => __DIR__ . '/../..' . '/helpers/import.php',
        'AcyMailing\\Helpers\\MailerHelper' => __DIR__ . '/../..' . '/helpers/mailer.php',
        'AcyMailing\\Helpers\\MigrationHelper' => __DIR__ . '/../..' . '/helpers/migration.php',
        'AcyMailing\\Helpers\\PaginationHelper' => __DIR__ . '/../..' . '/helpers/pagination.php',
        'AcyMailing\\Helpers\\PluginHelper' => __DIR__ . '/../..' . '/helpers/plugin.php',
        'AcyMailing\\Helpers\\QueueHelper' => __DIR__ . '/../..' . '/helpers/queue.php',
        'AcyMailing\\Helpers\\RegacyHelper' => __DIR__ . '/../..' . '/helpers/regacy.php',
        'AcyMailing\\Helpers\\SplashscreenHelper' => __DIR__ . '/../..' . '/helpers/splashscreen.php',
        'AcyMailing\\Helpers\\TabHelper' => __DIR__ . '/../..' . '/helpers/tab.php',
        'AcyMailing\\Helpers\\ToolbarHelper' => __DIR__ . '/../..' . '/helpers/toolbar.php',
        'AcyMailing\\Helpers\\UpdateHelper' => __DIR__ . '/../..' . '/helpers/update.php',
        'AcyMailing\\Helpers\\UserHelper' => __DIR__ . '/../..' . '/helpers/user.php',
        'AcyMailing\\Helpers\\WorkflowHelper' => __DIR__ . '/../..' . '/helpers/workflow.php',
        'AcyMailing\\Init\\ElementorForm' => __DIR__ . '/../..' . '/wpinit/elementorForm.php',
        'AcyMailing\\Init\\acyActivation' => __DIR__ . '/../..' . '/wpinit/activation.php',
        'AcyMailing\\Init\\acyAddons' => __DIR__ . '/../..' . '/wpinit/addons.php',
        'AcyMailing\\Init\\acyBeaver' => __DIR__ . '/../..' . '/wpinit/beaver.php',
        'AcyMailing\\Init\\acyCron' => __DIR__ . '/../..' . '/wpinit/cron.php',
        'AcyMailing\\Init\\acyDeactivate' => __DIR__ . '/../..' . '/wpinit/deactivate.php',
        'AcyMailing\\Init\\acyElementor' => __DIR__ . '/../..' . '/wpinit/elementor.php',
        'AcyMailing\\Init\\acyFakePhpMailer' => __DIR__ . '/../..' . '/wpinit/fake_phpmailer.php',
        'AcyMailing\\Init\\acyForms' => __DIR__ . '/../..' . '/wpinit/forms.php',
        'AcyMailing\\Init\\acyGutenberg' => __DIR__ . '/../..' . '/wpinit/gutenberg.php',
        'AcyMailing\\Init\\acyMenu' => __DIR__ . '/../..' . '/wpinit/menu.php',
        'AcyMailing\\Init\\acyMessage' => __DIR__ . '/../..' . '/wpinit/message.php',
        'AcyMailing\\Init\\acyOverrideEmail' => __DIR__ . '/../..' . '/wpinit/override_email.php',
        'AcyMailing\\Init\\acyRouter' => __DIR__ . '/../..' . '/wpinit/router.php',
        'AcyMailing\\Init\\acySecurity' => __DIR__ . '/../..' . '/wpinit/security.php',
        'AcyMailing\\Init\\acyUpdate' => __DIR__ . '/../..' . '/wpinit/update.php',
        'AcyMailing\\Init\\acyUsersynch' => __DIR__ . '/../..' . '/wpinit/usersynch.php',
        'AcyMailing\\Init\\acyWpRocket' => __DIR__ . '/../..' . '/wpinit/wprocket.php',
        'AcyMailing\\Libraries\\acymClass' => __DIR__ . '/../..' . '/libraries/class.php',
        'AcyMailing\\Libraries\\acymController' => __DIR__ . '/../..' . '/libraries/controller.php',
        'AcyMailing\\Libraries\\acymObject' => __DIR__ . '/../..' . '/libraries/object.php',
        'AcyMailing\\Libraries\\acymParameter' => __DIR__ . '/../..' . '/libraries/parameter.php',
        'AcyMailing\\Libraries\\acymPlugin' => __DIR__ . '/../..' . '/libraries/plugin.php',
        'AcyMailing\\Libraries\\acymView' => __DIR__ . '/../..' . '/libraries/view.php',
        'AcyMailing\\Libraries\\acympunycode' => __DIR__ . '/../..' . '/libraries/punycode.php',
        'AcyMailing\\Types\\AclType' => __DIR__ . '/../..' . '/types/acl.php',
        'AcyMailing\\Types\\CharsetType' => __DIR__ . '/../..' . '/types/charset.php',
        'AcyMailing\\Types\\DelayType' => __DIR__ . '/../..' . '/types/delay.php',
        'AcyMailing\\Types\\FailactionType' => __DIR__ . '/../..' . '/types/failaction.php',
        'AcyMailing\\Types\\FileTreeType' => __DIR__ . '/../..' . '/types/fileTree.php',
        'AcyMailing\\Types\\OperatorType' => __DIR__ . '/../..' . '/types/operator.php',
        'AcyMailing\\Types\\OperatorinType' => __DIR__ . '/../..' . '/types/operatorin.php',
        'AcyMailing\\Types\\UploadfileType' => __DIR__ . '/../..' . '/types/uploadFile.php',
        'AcyMailing\\Views\\AutomationViewAutomation' => __DIR__ . '/../..' . '/views/automation/view.html.php',
        'AcyMailing\\Views\\BouncesViewBounces' => __DIR__ . '/../..' . '/views/bounces/view.html.php',
        'AcyMailing\\Views\\CampaignsViewCampaigns' => __DIR__ . '/../..' . '/views/campaigns/view.html.php',
        'AcyMailing\\Views\\ConfigurationViewConfiguration' => __DIR__ . '/../..' . '/views/configuration/view.html.php',
        'AcyMailing\\Views\\DashboardViewDashboard' => __DIR__ . '/../..' . '/views/dashboard/view.html.php',
        'AcyMailing\\Views\\DynamicsViewDynamics' => __DIR__ . '/../..' . '/views/dynamics/view.html.php',
        'AcyMailing\\Views\\FieldsViewFields' => __DIR__ . '/../..' . '/views/fields/view.html.php',
        'AcyMailing\\Views\\FileViewFile' => __DIR__ . '/../..' . '/views/file/view.html.php',
        'AcyMailing\\Views\\FormsViewForms' => __DIR__ . '/../..' . '/views/forms/view.html.php',
        'AcyMailing\\Views\\GoproViewGopro' => __DIR__ . '/../..' . '/views/gopro/view.html.php',
        'AcyMailing\\Views\\LanguageViewLanguage' => __DIR__ . '/../..' . '/views/language/view.html.php',
        'AcyMailing\\Views\\ListsViewLists' => __DIR__ . '/../..' . '/views/lists/view.html.php',
        'AcyMailing\\Views\\MailsViewMails' => __DIR__ . '/../..' . '/views/mails/view.html.php',
        'AcyMailing\\Views\\OverrideViewOverride' => __DIR__ . '/../..' . '/views/override/view.html.php',
        'AcyMailing\\Views\\PluginsViewPlugins' => __DIR__ . '/../..' . '/views/plugins/view.html.php',
        'AcyMailing\\Views\\QueueViewQueue' => __DIR__ . '/../..' . '/views/queue/view.html.php',
        'AcyMailing\\Views\\SegmentsViewSegments' => __DIR__ . '/../..' . '/views/segments/view.html.php',
        'AcyMailing\\Views\\StatsViewStats' => __DIR__ . '/../..' . '/views/stats/view.html.php',
        'AcyMailing\\Views\\UsersViewUsers' => __DIR__ . '/../..' . '/views/users/view.html.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit621c9c90031d23133d364b119f138ba8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit621c9c90031d23133d364b119f138ba8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit621c9c90031d23133d364b119f138ba8::$classMap;

        }, null, ClassLoader::class);
    }
}
