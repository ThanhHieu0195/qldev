-- Update table guest_development_history
-- Add cloumn `is_history` tinyint 0: Nội dung đã liên hệ trước đó; 1: Lịch sử liên hệ khách hàng
UPDATE guest_development_history SET is_history = 1;