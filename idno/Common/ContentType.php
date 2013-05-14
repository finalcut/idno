<?php

    /**
     * All content types should extend this component.
     */

    namespace Idno\Common {

        class ContentType extends Component {

            // Property containing the entity class associated with this content type (default is generic object type)
            public $entity_class = 'Idno\\Entities\\Object';
            public $handler_class = 'Idno\\Common\\ContentType';
            public $title = 'Content type';

            // Static property containing register of all content types
            static public $registered = array();

            /**
             * Retrieves the icon associated with this content type
             * @param int $width The width of the icon to be returned. (Returned icon may not be the exact width.)
             * @return string The public URL to the content type.
             */
                function getIcon($width = 100) {
                    return ''; // TODO: create default icon to be returned
                }

            /**
             * Retrieves the name of the entity class associated with this content type
             * @return string
             */
                function getEntityClass()
                {
                    return $this->entity_class;
                }

                function getEntityClassName()
                {
                    $class = $this->getEntityClass();
                    return substr($class, strrpos($class,'\\') + 1);
                }

            /**
             * Create an object with the entity class associated with this content type
             * @return mixed
             */
                function createEntity() {
                    if (class_exists($this->entity_class)) {
                        $entity = new $this->entity_class();
                        return $entity;
                    }
                    return false;
                }

            /**
             * Return the name of this content type
             * @return string
             */
                function getTitle() {
                    return $this->title;
                }

            /**
             * Retrieves the URL to the form to create a new object related to this content type
             * @return string
             */
                function getEditURL() {
                    return \Idno\Core\site()->config()->url . $this->camelCase($this->getEntityClassName()) . '/edit';
                }

            /**
             * Register a content type as being available to create / edit
             *
             * @param $class The string name of a class that extends Idno\Common\ContentType.
             * @return bool
             */
                static function register($class) {
                    if (class_exists($class)) {
                        if (is_subclass_of($class,'Idno\\Common\\ContentType')) {
                            $contentType = new $class();
                            self::$registered[] = $contentType;
                            return true;
                        }
                    }
                    return false;
                }

            /**
             * Get all ContentType objects registered in the system.
             * @return array
             */
            static function getRegistered() {
                return self::$registered;
            }

        }

    }