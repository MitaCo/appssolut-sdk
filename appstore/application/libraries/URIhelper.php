<?php
class URIhelper extends Laravel\URI {

        /**
         * Get the last URI Segment from the URL
         * 
         * @return string
         */
        public static function last()
        {
                        static::current();

                        return str_replace('.'.static::extension(), '', end(static::$segments));
        }

        // --------------------------------------------------------------------

        /**
         * Get's the extension from the URL
         * 
         * @return string
         */
        public static function extension()
        {
                        return pathinfo(static::current(), PATHINFO_EXTENSION);
        }
}
