Link shortener

Working copy: http://3qa.ru

Installation:

1. Add this block to nginx configuration:

        location / {                                
                try_files $uri $uri/ /index.php?$args;
        }

2. Copy config.dist.php to config.php

        cp config.dist.php config.php

3. Fill parameters in config.php:

        //Database config:
            dbtype
            dbname
            host
            username
            password
            charset
        
        // Google secret captha keys:
            secret_key
            public_key
            
        // Web of trust secret key:            
            'wot_secret_key' => "",
        // Web of trust min reputation to show link:
            'min_wot_reputation' => "",
        // Master password:    
            'save_image_password' => "",        
        
4. Set up .sql files in /installation/ folder