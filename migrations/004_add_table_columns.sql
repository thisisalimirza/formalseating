-- Add table_id and seat_number columns to seats table
ALTER TABLE seats ADD COLUMN table_id INTEGER;
ALTER TABLE seats ADD COLUMN seat_number INTEGER;

-- Update existing records with calculated values
UPDATE seats 
SET 
    table_id = FLOOR((seat_id - 1) / 10) + 1,
    seat_number = ((seat_id - 1) % 10) + 1
WHERE table_id IS NULL; 