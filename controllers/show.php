<?php

class ShowController extends StudipController {

    public function __construct($dispatcher) {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;

        $this->init();
    }

    public function before_filter(&$action, &$args) {

        $this->set_layout($GLOBALS['template_factory']->open('layouts/base_without_infobox'));
        if (class_exists("Sidebar")) {
            Sidebar::get()->setImage($this->plugin->getPluginURL()."/assets/images/sidebar.png");
        }
        PageLayout::setTitle($GLOBALS['SessSemName']["header_line"]." - ".$this->plugin->getDisplayTitle());
    }

    public function index_action() {
        
    }

    public function create_action() {
        Navigation::activateItem("/course/brainstorm");

        if (Request::isPost() && Request::submitted('create')) {
            CSRFProtection::verifySecurityToken();
            $GLOBALS['perm']->check('tutor', Course::findCurrent()->id);
            $data = Request::getArray('brainstorm');
            $data['range_id'] = Course::findCurrent()->id;
            Brainstorm::create($data);
            $this->redirect('show/index');
        }
    }

    public function brainstorm_action($id) {
        $this->brainstorm = $this->brainstorms->find($id);

        // Insert new subbrainstorm
        if (Request::isPost() && Request::submitted('create')) {
            CSRFProtection::verifySecurityToken();
            $this->brainstorm->answer(Request::get('answer'));
        }

        // Check if vote is required
        if (Request::isPost() && Request::submitted('vote')) {
            CSRFProtection::verifySecurityToken();
            $brainstorm = new Brainstorm(Request::get('brainstorm'));
            $brainstorm->vote(key(Request::getArray('vote')));
        }
    }

    private function init() {
        $this->brainstorms = SimpleORMapCollection::createFromArray(Brainstorm::findByRange_id(Course::findCurrent()->id));
        foreach ($this->brainstorms as $brainstorm) {
            Navigation::addItem('/course/brainstorm/' . $brainstorm->id, new AutoNavigation(htmlReady($brainstorm->title), PluginEngine::GetURL($this->plugin, array(), 'show/brainstorm/' . $brainstorm->id)));
        }

        // Create sidebar
        if ($GLOBALS['perm']->have_studip_perm('tutor', Course::findCurrent()->id)) {
            $sidebar = Sidebar::Get();
            $actions = new ActionsWidget();
            $actions->addLink(_('Neuen Brainstorm anlegen'), PluginEngine::GetURL($this->plugin, array(), 'show/create'), 'icons/16/blue/add.png');
            $sidebar->addWidget($actions);
        }
    }

    // customized #url_for for plugins
    function url_for($to) {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->plugin, $params, join('/', $args));
    }

}
