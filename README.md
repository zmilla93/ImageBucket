# ImageBucket

ImageBucket is a proof of concept image hosting website. It doesn't use any 3rd party software.

[View the live site!](https://img.zrmiller.com/)

# Features
- Account creation
- Image upload & deletion
- Thumbnail creation
- Profile page
- Individual image page

Single Page Application
=======================
Even when viewing profiles or individual images, the only page ever served is index.php. This is done by using htaccess rewrite rules to convert certain URLs into php GET statements. For example, vising `img.zrmiller.com/u/testuser` uses the rule

```
RewriteCond %{REQUEST_URI} ^/u/.+$
RewriteRule ^/?u/(.+)$ /index.php?profile=$1 [L]
```

to reinterpret the url as `img.zrmiller.com/index.php?profile=testuser`. This GET statement then triggers an include in index.php to add the contents of `includes_img/page/profile.php`, which handles displaying the images uploaded by the target user.

Image Uploading & Display
===============
When images are uploaded, they have a thumbnail created automatially if the file type is supported (png, jpg, gif, webp). Uploaded files are stored outside of the root directory of the website, so they cannot be viewed directly.

To serve an image, metadata is fetched from the database, added to the reponse header, then the image file is output using php. This allows for features such as privacy settings (not implemented) or fallback images. For example, if you request a thumbnail of an image with no thumbnail, the full sized image will be served instead. If you request a nonexistant image, a generic image is served instead.
