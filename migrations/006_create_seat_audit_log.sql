-- Create seat_audit_log table
CREATE TABLE IF NOT EXISTS seat_audit_log (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    seat_id INTEGER NOT NULL,
    table_id INTEGER NOT NULL,
    action_type VARCHAR(50) NOT NULL, -- 'select', 'deselect', 'admin_clear', etc.
    previous_user_id INTEGER REFERENCES users(id),
    performed_by_id INTEGER REFERENCES users(id),
    is_admin_action BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create index for faster queries
CREATE INDEX idx_seat_audit_log_created_at ON seat_audit_log(created_at);
CREATE INDEX idx_seat_audit_log_user_id ON seat_audit_log(user_id);
CREATE INDEX idx_seat_audit_log_seat_id ON seat_audit_log(seat_id);

-- Add comment for documentation
COMMENT ON TABLE seat_audit_log IS 'Tracks all changes to seat assignments including who made the change'; 