<?php
/**
 * Handles the view functionality
 */
class View_Model
{
    /**
     * Holds render status of view.
     *
     * @var bool
     */
    protected $render = false;
    protected $content = "";

    /**
     * Constructor
     *
     * Accept a template to load
     *
     * @param string $template
     */
    public function __construct($template)
    {
        //compose file name
        $file = SERVER_ROOT . '/views/' . strtolower($template) . '.phtml';

        if (file_exists($file))
        {
            $this->render = $file;
        }
    }

    /**
     * Function to set the content to be displayed within the view template
     *
     * @param $content
     */
    public function setContent($content){
        $this->content = $content;
    }

    /**
     * Function to return the content value
     *
     * @return string
     */
    public function getContent(){
        return $this->content;
    }

    /**
     * Render the view and include button logic
     */
    public function renderView()
    {
        $buttons = new Button_Model();
        $content = $this->getContent();
        include($this->render);
        $buttons->display();
        $buttons->initDisplay();
    }
}