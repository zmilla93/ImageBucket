-- These are a bunch of queries used for prototyping or debugging.

-- Use the databse
USE zrimage;

-- Get all data from tables  
SELECT * from users;
SELECT * from images;

-- Get all images by a user
select uuid, mime, extension, time_uploaded from images
INNER JOIN users on users.id = images.author
where users.username = 'asdf';

-- Get image by uuid
SELECT username, uuid, extension, mime FROM images
INNER JOIN users ON users.id = images.author
WHERE images.uuid = 'ZLavQnTK'
COLLATE `utf8mb4_bin`; -- Using collate makes query case sensitive

-- Modify Table
ALTER TABLE images ADD thumbnail bit NOT NULL DEFAULT 0;
ALTER TABLE images ADD animated bit NOT NULL DEFAULT 0;

-- Insert Dummy Image
INSERT INTO images (uuid, mime, extension, author) VALUES ('abcd', 'image/png', 'png', 2);

-- Get user info
SELECT * FROM users WHERE username = 'asdf';

-- Check UUID
SELECT id FROM images WHERE uuid = 'pxYUNKcg';

-- Get Image Owner
SELECT username FROM images
INNER JOIN users ON users.id = images.author
WHERE uuid = 'yhNfJcSd'
COLLATE `utf8mb4_bin`;

-- Validate a user is the owner of an image
SELECT username, users.id, uuid, extension, mime FROM images
INNER JOIN users ON users.id = images.author
WHERE users.id = '2' AND images.uuid = 'ZLavQnTK';