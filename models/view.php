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
    private $render = FALSE;

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
        $file = SERVER_ROOT . '/views/' . strtolower($template) . '.php';

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

    /**
     * Render the view
     */
    public function renderView()
    {

        include($this->render);
        $buttons = new Button_Model();
        $buttons->display();

    }
}