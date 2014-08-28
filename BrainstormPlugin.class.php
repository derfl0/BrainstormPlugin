<?php

require 'bootstrap.php';

/**
 * BrainstormPlugin.class.php
 *
 * ...
 *
 * @author  Florian Bieringer <florian.bieringer@uni-passau.de>
 * @version 1.0
 */
class BrainstormPlugin extends StudIPPlugin implements StandardPlugin {

    public function initialize() {


        PageLayout::addStylesheet($this->getPluginURL() . '/assets/style.css');
        PageLayout::addScript($this->getPluginURL() . '/assets/autoresize.jquery.min.js');
        PageLayout::addScript($this->getPluginURL() . '/assets/application.js');
    }

    public function getTabNavigation($course_id) {
        $navigation = new AutoNavigation($this->getDisplayTitle());
        $navigation->setURL(PluginEngine::GetURL($this, array(), 'show/index'));
        $navigation->setActiveImage($this->getPluginURL() . '/assets/images/brainstorm.png');
        $navigation->setImage($this->getPluginURL() . '/assets/images/brainstorm_active.png');
        
        // Add Subnavigation
        $navigation->addSubNavigation('index', new AutoNavigation(_('Übersicht'), PluginEngine::GetURL($this, array(), 'show/index')));
        
        return array('brainstorm' => $navigation);
    }

    public function getNotificationObjects($course_id, $since, $user_id) {
        return array();
    }

    public function getIconNavigation($course_id, $last_visit, $user_id) {
        $new = Brainstorm::findBySQL("range_id = ? AND chdate > ?", array($course_id, $last_visit));
        $size = $GLOBALS['auth']->auth['devicePixelRatio'] > 1.2 ? 40 : 20;
        $icon = new Navigation($this->getDisplayTitle(), PluginEngine::GetURL($this, array('cid' => $course_id), 'show/index'));
        $icon->setImage($this->getPluginURL() . '/assets/images/brainstorm_'.$size.'_grey.png', array('title' => $this->getDisplayTitle()));
        if (count($new)) {
            $icon->setImage($this->getPluginURL() . '/assets/images/brainstorm_'.$size.'_red.png', array('title' => sprintf(_("Neuer %s verfügbar"), $this->getDisplayTitle())));
        }
        return $icon;
    }

    public function getInfoTemplate($course_id) {
        return null;
    }

    public function getDisplayTitle() {
        return _("Brainstorm");
    }

    public function perform($unconsumed_path) {
        $this->setupAutoload();
        $dispatcher = new Trails_Dispatcher(
                $this->getPluginPath(), rtrim(PluginEngine::getLink($this, array(), null), '/'), 'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
    }

    private function setupAutoload() {
        if (class_exists("StudipAutoloader")) {
            StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
        } else {
            spl_autoload_register(function ($class) {
                include_once __DIR__ . $class . '.php';
            });
        }
    }

}
