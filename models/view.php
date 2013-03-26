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
            /**
             * trigger render to include file when this model is destroyed
             * if we render it now, we wouldn't be able to assign variables
             * to the view!
             */
            $this->render = $file;
        }
    }

    public function setContent($content){
        $this->content = $content;
    }

    /**
     * Render the view
     */
    public function renderView()
    {
        $buttons = new Button_Model();
        $content = $this->content;
        include($this->render);
        $buttons->display();
        $buttons->initDisplay();
    }


}