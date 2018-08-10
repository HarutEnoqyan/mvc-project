ALTER TABLE messages
  ADD COLUMN seen SMALLINT(11) AFTER updated_at;