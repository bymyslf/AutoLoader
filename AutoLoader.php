<?php
    class AutoLoader
    {
        protected $paths = array();
        protected $extensions = array();
        
        public function __construct($autoLoadPaths = null, $autoLoadExtensions = null) {
            if (!is_null($autoLoadPaths)) {
                if (is_array($autoLoadPaths)) {
                    $this->paths = $autoLoadPaths;    
                } else {
                     $this->paths[] = $autoLoadPaths;
                }
            } else {
                $this->paths[] = '/';
            }
            
            if (!is_null($autoLoadExtensions)) {
                if (is_array($autoLoadExtensions)) {
                    $this->extensions = $autoLoadExtensions;    
                } else {
                     $this->extensions[] = $autoLoadExtensions;
                }
            } else {
                $this->extensions[] = '.php';
            }
            
            spl_autoload_register(array($this, 'loader'));
        }
        
        protected function loader($className) {
            foreach ($this->paths as $path) {
                $path = ($this->endsWith('/')) ? $path : $path . '/';
                foreach ($this->extensions as $extension) {
                    $filepath = $path . $className . $extension;
                    if (file_exists($filepath)) {
                        require $filepath;
                        break 2;
                    }
                }
            }
        }
        
        protected function endsWith($haystack, $needle) {
			$length = strlen($needle);
			$start  = $length * - 1;
			return (substr($haystack, $start) === $needle);
		}
    }
?>