<?php

class Content_Messenger {
    /**
     * A reference to the class for retrieving our option values.
     *
     * @access private
     * @var    Deserializer
     */
    private $deserializer;
     
    /**
     * Initializes the class by setting a reference to the incoming deserializer.
     *
     * @param Deserializer $deserializer Retrieves a value from the database.
     */
    public function __construct( $deserializer ) {
        $this->deserializer = $deserializer;
    }
    
    /**
     * Initializes the hook responsible for prepending the content with the
     * option created on the options page.
     */
    public function init() {
        add_filter( 'the_content', array( $this, 'display_custom_template' ) );
    }
    
    public function display_custom_template($content) {
        /* Youn set the tesmplate here */
    }
}