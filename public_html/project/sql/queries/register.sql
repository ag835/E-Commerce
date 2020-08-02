INSERT INTO Users (email, username, password, country) VALUES (:email, :username, :password, :country);
INSERT INTO UserRoles (user_id, role_id, is_active) VALUES (:user_id, 2, 1)