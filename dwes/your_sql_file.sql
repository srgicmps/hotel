ALTER TABLE `062_rooms`
ADD CONSTRAINT fk_room_category
FOREIGN KEY (room_category_id)
REFERENCES `062_room_categories`(room_category_id)
ON DELETE CASCADE
ON UPDATE CASCADE;
