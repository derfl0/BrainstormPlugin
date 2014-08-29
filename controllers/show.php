<?php

class ShowController extends StudipController {

    public function __construct($dispatcher) {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
    }

    public function before_filter(&$action, &$args) {

        if (Request::isXhr()) {
            $this->set_content_type('text/html;Charset=windows-1252');
        } else {
            $this->set_layout($GLOBALS['template_factory']->open('layouts/base_without_infobox'));
        }

        // Load brainstorm
        if ($args) {
            $this->brainstorm = Brainstorm::find($args[0]);
            $this->range_id = $args[0];
        }

        $this->init();
    }

    public function index_action() {
        
    }

    public function create_action($range_id = null) {
        if (Request::submitted('create')) {
            CSRFProtection::verifySecurityToken();
            $data = Request::getArray('brainstorm');
            $data['user_id'] = User::findCurrent()->id;
            $data['seminar_id'] = Course::findCurrent()->id;

            // Check if we are allowed to post that brainstorm
            if ($GLOBALS['perm']->check('dozent', Course::findCurrent()->id) || $this->brainstorm->type == "sub") {
                Brainstorm::create($data);
                $this->redirect('show/index');
            }
        }
        $this->range_id = $range_id;
    }

    public function brainstorm_action($id) {

        // Insert new subbrainstorm
        if (Request::submitted('create')) {
            CSRFProtection::verifySecurityToken();
            $this->brainstorm->answer(Request::get('answer'));
        }

        // Check if vote is required
        if (Request::submitted('vote')) {
            CSRFProtection::verifySecurityToken();
            $brainstorm = new Brainstorm(Request::get('brainstorm'));
            $brainstorm->vote(key(Request::getArray('vote')));
        }
    }

    private function init() {

        // Produce navigation
        $this->brainstorms = SimpleORMapCollection::createFromArray(Brainstorm::findByRange_id(Course::findCurrent()->id));
        foreach ($this->brainstorms as $brainstorm) {
            Navigation::addItem('/course/brainstorm/' . $brainstorm->id, new AutoNavigation(htmlReady($brainstorm->title), PluginEngine::GetURL($this->plugin, array(), 'show/brainstorm/' . $brainstorm->id)));
        }

        // Fetch sidebar
        $sidebar = Sidebar::Get();

        // Active navigation
        if ($this->brainstorm) {
            $current = $this->brainstorm;
            while (!Navigation::hasItem('/course/brainstorm/' . $current->id)) {
                $current = $current->parent;
            }
            Navigation::activateItem('/course/brainstorm/' . $current->id);
        }

        // Create actions

        $actions = new ActionsWidget();
        if ($GLOBALS['perm']->have_studip_perm('tutor', Course::findCurrent()->id)) {
            $actions->addLink(_('Neuen Brainstorm anlegen'), PluginEngine::GetURL($this->plugin, array(), 'show/create/' . Course::findCurrent()->id), 'icons/16/blue/add.png', array('data-dialog' => 'size=auto;buttons=false;resize=false'));
        }

        if ($this->brainstorm->type == 'sub') {
             $actions->addLink(_('Neuen Subbrainstorm anlegen'), PluginEngine::GetURL($this->plugin, array(), 'show/create/' . $this->brainstorm->id), 'icons/16/blue/add.png', array('data-dialog' => 'size=auto;buttons=false;resize=false'));
           
        }
        $sidebar->addWidget($actions);
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
