<?php
/**
 * Vector - Modern version of MonoBook with fresh look and many usability
 * improvements.
 *
 * @todo document
 * @file
 * @ingroup Skins
 */
if (!defined('MEDIAWIKI')) {
    die(-1);
}

/**
 * SkinTemplate class for Vector skin
 * @ingroup Skins
 */
class SkinBootstrapped extends SkinTemplate
{

    var $skinname = 'bootstrapped',
            $stylename = 'bootstrapped',
            $template = 'BootstrappedTemplate',
            $useHeadElement = true;

    /**
     * Initializes output page and sets up skin-specific parameters
     * @param $out OutputPage object to initialize
     */
    public function initPage(OutputPage $out)
    {
        global  $wgHandheldStyle,
                $wgJsMimeType,
                $wgScriptPath,
                $wgLocalStylePath,
                $wgRequest,
                $wgStylePath;

        parent::initPage($out);

        parent::setupSkinUserCss($out);

        if ($wgHandheldStyle) {
            // Currently in testing... try 'chick/main.css'
            $out->addStyle($wgHandheldStyle, 'handheld');
        }

        $out->addStyle($wgStylePath.'/bootstrapped/css/bs/bootstrap.min.css', 'screen');
        $out->addStyle($wgStylePath.'/bootstrapped/css/bs/bootstrap-responsive.min.css', 'screen');
        $out->addStyle($wgStylePath.'/bootstrapped/css/gcp/prettify.css', 'screen');
        $out->addStyle($wgStylePath.'/bootstrapped/css/default.css', 'screen');
        
        $out->addScriptFile($wgStylePath.'/bootstrapped/js/jq/jquery-1.7.2.min.js');
        $out->addScriptFile($wgStylePath.'/bootstrapped/js/gcp/prettify.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/jq/jquery-ui-1.8.18.custom.min.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-transition.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-alert.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-modal.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-dropdown.js');
        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-scrollspy.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-tab.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-tooltip.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-popover.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-button.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-collapse.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-carousel.js');
//        $out->addScriptFile($wgStylePath.'/bootstrapped/js/bs/bootstrap-typeahead.js');
        $out->addScriptFile($wgStylePath.'/bootstrapped/js/default.js');
        // Append CSS which includes IE only behavior fixes for hover support -
        // this is better than including this in a CSS fille since it doesn't
        // wait for the CSS file to load before fetching the HTC file.
//		$out->addHeadItem( 'csshover',
//			'<!--[if lt IE 7]><style type="text/css">body{behavior:url("' .
//				htmlspecialchars( $wgLocalStylePath ) .
//				"/{$this->stylename}/csshover{$min}.htc\")}</style><![endif]-->"
//		);
    }

    /**
     * Load skin and user CSS files in the correct order
     * fixes bug 22916
     * @param $out OutputPage object
     */
    function setupSkinUserCss(OutputPage $out)
    {
        parent::setupSkinUserCss($out);
        $out->addModuleStyles('skins.bootstrapped');
    }

}

/**
 * QuickTemplate class for Vector skin
 * @ingroup Skins
 */
class BootstrappedTemplate extends QuickTemplate
{

    var $skin;

    /**
     * Template filter callback for gmwfreegreen skin.
     * Takes an associative array of data set from a SkinTemplate-based
     * class, and a wrapper for MediaWiki's localization database, and
     * outputs a formatted page.
     *
     * @access private
     */
    function execute()
    {
        global  $wgRequest, 
                $wgLogo, 
                $wgScriptPath, 
                $wgUser, 
                $wgSitename;
        
        $this->skin = $skin = $this->data['skin'];
        $action = $wgRequest->getText('action');

        // Suppress warnings to prevent notices about missing indexes in $this->data
        wfSuppressWarnings();

        $this->html('headelement');
        ?>

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="brand" href="<?php echo $wgServer ?>"><?php echo $wgSitename ?></a>
                    
                    <form class="navbar-search" action="/index.php" id="searchform" style="margin-left:25px;">
                        <input type="hidden" name="title" value="Special:Search">
                        <input id="searchInput" 
                               type="text" 
                               title="<?php echo $this->skin->titleAttrib('search') ?>" 
                               name="search" 
                               class="search-query" 
                               accesskey="<?php echo $this->skin->accesskey('search') ?>" 
                               placeholder="Search" 
                               name="q" 
                               value="<?php echo isset($this->data['search']) ? $this->data['search'] : '' ?>" 
                               />
                    </form>
                    
                    <div class="nav-collapse pull-right">
                        <ul <?php $this->html('userlangattributes') ?> class="nav">
                            <?php foreach ($this->data['personal_urls'] as $key => $item) { ?>
                                <li id="<?php echo Sanitizer::escapeId("pt-$key") ?>"<?php if ($item['active']) { ?> class="active"<?php } ?>>
                                    <a href="<?php echo htmlspecialchars($item['href']) ?>"<?php echo $this->tooltipAndAccesskey('pt-' . $key) ?><?php if (!empty($item['class'])) { ?> class="<?php echo htmlspecialchars($item['class']) ?>"<?php } ?>>
                                        <?php echo $this->getIcon($key, $item['active'] ? 'offwhite' : 'grey'); ?>
                                        <?php echo htmlspecialchars($item['text']) ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container-fluid">
            
            <div class="row-fluid">
                <div class="span2">
                    <div class="well sidebar-nav">
                        <ul class="nav nav-list">
                            <?php
                            $sidebar = $this->data['sidebar'];
                            
                            if (!isset($sidebar['TOOLBOX'])) {
                                $sidebar['TOOLBOX'] = true;
                            }
                            if (!isset($sidebar['LANGUAGES'])) {
                                $sidebar['LANGUAGES'] = true;
                            }
                            
                            foreach ($sidebar as $boxName => $cont) {
                                if ($boxName == 'navigation' && count($cont)) {
                                    ?>
                                    <li class="nav-header">GO TO</li>
                                    <?php
                                    if (is_array($cont)) { 
                                        foreach ($cont as $key => $val) { 
                                        ?>
                                            <li <?php if ($val['active']) { ?> class="active" <?php } ?>>
                                                <a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo $this->tooltipAndAccesskey($val['id']) ?>>
                                                    <?php echo htmlspecialchars($val['text']) ?>
                                                </a>
                                            </li>
                                        <?php 
                                        }
                                    }
                                } elseif ($boxName == 'TOOLBOX') {
                                    $this->toolBox();
                                } elseif ($boxName == 'LANGUAGES') {
                                    $this->languageBox();
                                } elseif ($boxName != 'SEARCH' && $boxName != 'navigation') {
                                    $this->customBox($boxName, $cont);
                                }
                            }
                            ?>
                        </ul>
                    </div><!--/.well -->
                </div><!--/span-->
                <div class="span10" id="page-content" <?php $this->html("specialpageattributes") ?> style="display:none;">
                    <a id="top"></a>
                    
                    <?php if ($this->data['sitenotice']) { ?>
                        <div id="siteNotice"><?php $this->html('sitenotice') ?></div>
                    <?php } ?>
                        
                    <div class="pull-right">
                        <?php if (!$wgUser->isAnon()) { ?>
                            <div class="subnav">
                                <ul class="nav nav-pills">
                                    <?php
                                        foreach ($this->data['content_actions'] as $key => $tab) {
                                            $class = htmlspecialchars($tab['class'] == 'selected' ? 'active' : $tab['class']);
                                            $href = htmlspecialchars($tab['href']);
                                            $label = htmlspecialchars($tab['text']);
                                            if (in_array($action, array('edit', 'submit')) && in_array($key, array('edit', 'watch', 'unwatch'))) {
                                                $tooltip = $skin->tooltip("ca-$key");
                                            } else {
                                                $tooltip = $this->tooltipAndAccesskey("ca-$key");
                                            }
                                            ?>
                                            <li class="<?php echo $class ?>">
                                                <a href="<?php echo $href ?>" <?php echo $tooltip ?>><?php echo $label ?></a>
                                            </li>
                                            <?php
                                        }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>

                    <h1 id="firstHeading" class="firstHeading"><?php $this->html('title') ?></h1>
                    
                    <hr />
                            
                    <div class="serviceInfoTop">
                        <?php if ($this->data['undelete']) { ?>
                            <div id="contentSub2"><?php $this->html('undelete') ?></div>
                        <?php } ?>
                        <?php if ($this->data['newtalk']) { ?>
                            <div class="usermessage"><?php $this->html('newtalk') ?></div>
                        <?php } ?>
                    </div>
                    
                    <?php $this->html('bodytext') ?>
                    
                    <?php if ($this->data['catlinks']) { $this->html('catlinks'); } ?>

                    <?php
                        // Generate additional footer links
                        $footerlinks = array(
                            'lastmod', 'viewcount',
                        );
                        $validFooterLinks = array();
                        foreach ($footerlinks as $aLink) {
                            if (isset($this->data[$aLink]) && $this->data[$aLink]) {
                                $validFooterLinks[] = $aLink;
                            }
                        }
                    ?>
                    <?php if (count($validFooterLinks) > 0) { ?>
                        <?php
                        foreach ($validFooterLinks as $aLink) {
                            if (isset($this->data[$aLink]) && $this->data[$aLink]) {
                                ?>
                                <span id="<?php echo $aLink ?>"><?php $this->html($aLink) ?></span> &nbsp; 
                                <?php
                            }
                        }
                        ?>
                    <?php } ?>


                    <?php if ($this->data['dataAfterContent']) { ?>
                        <?php $this->html('dataAfterContent'); ?>
                    <?php } ?>
                    
                    
                    <hr>

                    <footer>
                        <div class="pull-right">
                            <?php $this->html('poweredbyico') ?>
                            <?php $this->html('copyrightico') ?>
                        </div>
                        <p>
                        <?php
                        // Generate additional footer links
                        $footerlinks = array(
                            'numberofwatchingusers', 'credits', 'copyright',
                            'privacy', 'about', 'disclaimer', 'tagline',
                        );
                        $validFooterLinks = array();
                        foreach ($footerlinks as $aLink) {
                            if (isset($this->data[$aLink]) && $this->data[$aLink]) {
                                $validFooterLinks[] = $aLink;
                            }
                        }
                        ?>
                        <?php if (count($validFooterLinks) > 0) { ?>	
                            <?php
                            $first = true;
                            foreach ($validFooterLinks as $aLink) {
                                if (isset($this->data[$aLink]) && $this->data[$aLink]) {
                                    if(!$first) {
                                        echo " | ";
                                    }
                                    $this->html($aLink);
                                    $first = false;
                                }
                            }
                            ?>
                        <?php } ?>
                        </p>
                    </footer>
                    

                </div><!--/span-->
            </div><!--/row-->


        </div>

        <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
        <?php $this->html('reporttime') ?>
        <?php if ($this->data['debug']): ?>
            <!-- Debug output:
            <?php $this->text('debug'); ?>
            -->
        <?php endif; ?>
        </body>
        </html>
        
        <?php
        wfRestoreWarnings();
    } // EO execute()


    /* ********************************************************************************************** */

    function toolBox()
    {
    ?>
        <li class="nav-header"><?php $this->msg('toolbox') ?></li>
        <?php if ($this->data['notspecialpage']) { ?>
            <li id="t-whatlinkshere">
                <a href="<?php echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href']) ?>" <?php echo $this->tooltipAndAccesskey('t-whatlinkshere') ?>>
                    <?php $this->msg('whatlinkshere') ?>
                </a>
            </li>
            <?php if ($this->data['nav_urls']['recentchangeslinked']) { ?>
                <li id="t-recentchangeslinked">
                    <a href="<?php echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href']) ?>"<?php echo $this->tooltipAndAccesskey('t-recentchangeslinked') ?>>
                        <?php $this->msg('recentchangeslinked-toolbox') ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>

        <?php if (isset($this->data['nav_urls']['trackbacklink']) && $this->data['nav_urls']['trackbacklink']) { ?>
            <li id="t-trackbacklink">
                <a href="<?php echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href']) ?>"<?php echo $this->tooltipAndAccesskey('t-trackbacklink') ?>>
                    <?php $this->msg('trackbacklink') ?>
                </a>
            </li>
        <?php } ?>
        <?php if ($this->data['feeds']) { ?>
            <li id="feedlinks">
                <?php foreach ($this->data['feeds'] as $key => $feed) { ?>
                    <a id="<?php echo Sanitizer::escapeId("feed-$key") ?>" href="<?php echo htmlspecialchars($feed['href']) ?>" rel="alternate" type="application/<?php echo $key ?>+xml" class="feedlink"<?php echo $this->tooltipAndAccesskey('feed-' . $key) ?>>
                        <?php echo htmlspecialchars($feed['text']) ?>
                    </a>
                    &nbsp;
                <?php } ?>
            </li>
        <?php } ?>
        <?php 
        foreach (array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special) {
            if ($this->data['nav_urls'][$special]) {
                ?>
                <li id="t-<?php echo $special ?>">
                    <a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href']) ?>"<?php echo $this->tooltipAndAccesskey('t-' . $special) ?>>
                        <?php $this->msg($special) ?>
                    </a>
                </li>
                <?php
            }
        }
        ?>
        <?php if (!empty($this->data['nav_urls']['print']['href'])) { ?>
            <li id="t-print">
                <a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])?>" rel="alternate"<?php echo $this->tooltipAndAccesskey('t-print') ?>>
                    <?php $this->msg('printableversion') ?>
                </a>
            </li>
        <?php } ?>
        <?php if (!empty($this->data['nav_urls']['permalink']['href'])) { ?>
            <li id="t-permalink">
                <a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href']) ?>"<?php echo $this->tooltipAndAccesskey('t-permalink') ?>>
                    <?php $this->msg('permalink') ?>
                </a>
            </li>
        <?php } elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
            <li id="t-ispermalink"<?php echo $this->skin->tooltip('t-ispermalink') ?>>
                <?php $this->msg('permalink') ?>
            </li>
        <?php } ?>
        <?php
            wfRunHooks('MonoBookTemplateToolboxEnd', array(&$this));
            wfRunHooks('SkinTemplateToolboxEnd', array(&$this));
        ?>
    <?php
    } // EO toolbox()

    /* ********************************************************************************************** */

    function languageBox()
    {
        if ($this->data['language_urls']) {
        ?>
            <li class="nav-header" <?php $this->html('userlangattributes') ?>><?php $this->msg('otherlanguages') ?></li>
            <?php foreach ($this->data['language_urls'] as $langlink) { ?>
                <li class="<?php echo htmlspecialchars($langlink['class']) ?>">
                    <a href="<?php echo htmlspecialchars($langlink['href']) ?>"><?php echo $langlink['text'] ?></a>
                </li>
            <?php } ?>
        <?php
        }
    } // EO languageBox()

    /* ********************************************************************************************** */

    function customBox($boxName, $cont)
    {
        $title = wfMsg($boxName); 
        if (wfEmptyMsg($boxName, $title)) { 
            $title = htmlspecialchars($boxName); 
        }
        else {
            $title = htmlspecialchars($title); 
        }
        ?>
        <li class="nav-header"><?php echo $title ?></li>
        <?php
        if (is_array($cont)) { 
            foreach ($cont as $key => $val) { 
            ?>
                <li <?php if ($val['active']) { ?> class="active" <?php } ?>>
                    <a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo $this->tooltipAndAccesskey($val['id']) ?>>
                        <?php echo htmlspecialchars($val['text']) ?>
                    </a>
                </li>
            <?php 
            }
        }
    } // EO customBox();


    function tooltipAndAccesskey($name)
    {
        global $wgVersion;
        
        if (version_compare($wgVersion, '1.18.0', '<')) {
            return $this->skin->tooltipAndAccesskey($name);
        } else {
            $returnString = ' ';
            foreach (Linker::tooltipAndAccesskeyAttribs($name) as $key => $item) {
                $returnString += $key + '="' + $item + '" ';
            }
            return $returnString;
        }
    } // EO tooltipAndAccesskey
    
    function getIcon($key, $colour = '') {
        if(!in_array($colour, array('white','offwhite','grey','blue','deepblue'))) {
            $colour = '';
        }
        $colourClass = $colour ? "icon-$colour" : '';
        switch($key) {
            case 'anonlogin':   // pass through
            case 'login':   // pass through
            case 'userpage':    return '<i class="icon-user '.$colourClass.'"></i>';
            case 'mytalk':      return '<i class="icon-comment '.$colourClass.'"></i>';
            case 'preferences': return '<i class="icon-cog '.$colourClass.'"></i>';
            case 'watchlist':   return '<i class="icon-eye-open '.$colourClass.'"></i>';
            case 'mycontris':   return '<i class="icon-check '.$colourClass.'"></i>';
            case 'logout':      return '<i class="icon-off '.$colourClass.'"></i>';
            default:            return "";
        }
    }

} // EO BootstrappedTemplate