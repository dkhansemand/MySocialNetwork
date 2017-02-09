SELECT userdetails.Firstname, userdetails.Surname, userdetails.Age,
userdetails.City, userdetails.Gender, userdetails.Employment, userdetails.Hobbies,
userdetails.UserId, users.id AS userID, users.email, users.Username
FROM userdetails 
INNER JOIN users ON userdetails.UserId = users.Id
WHERE userdetails.Firstname OR userdetails.Surname OR userdetails.City OR users.Email LIKE '%.com%' ;