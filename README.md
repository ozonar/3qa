Link shortener

Example: http://3qa.ru

Add this block to nginx configuration:

        location / {                                
                try_files $uri $uri/ /index.php?$args;
        }

