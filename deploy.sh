#!/bin/sh
rsync -av ./ q89ai_movkitchen@movkitchen.fr:~/sites/pepperdev.fr --include=public/build --include=public/.htaccess --include=public/bundles --include=vendor --exclude-from=.gitignore --exclude=".*"
