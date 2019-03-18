CREATE TABLE `users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `username`, `name`, `email`) VALUES
(1, 'yssyogesh', 'Yogesh singh', 'yssyogesh@gmail.com'),
(2, 'sonarika', 'Sonarika', 'sonarika@gmail.com'),
(3, 'vishal', 'Vishal Sahu', 'vishal@gmail.com'),
(4, 'mayank', 'Mayank', 'mayank@yahoo.com'),
(5, 'vijay', 'Vijay', 'vijayec@gmai.com'),
(6, 'jiten', 'Jiten singh', 'jiten93@gmail.com'),
(7, 'rahul', 'Rahul singh', 'rahul@gmail.com'),
(8, 'shreya', 'Shreya', 'shreya@yahoo.com'),
(9, 'mohit', 'Mohit', 'mohit@gmail.com'),
(10, 'rohit', 'Rohit singh', 'rohit@gmail.com'),
(11, 'abhilash', 'Abhilash ', 'abhilash@gmail.com'),
(12, 'abhishek', 'Abhishek', 'abhishek@yahoo.com'),
(13, 'aditya', 'Aditya', 'aditya@gmail.com'),
(14, 'ajay', 'Ajay singh', 'ajay@gmail.com'),
(15, 'akhilesh', 'Akhilesh', 'akhilesh@yahoo.com'),
(17, 'deepak', 'Deepak', 'deepak@gmail.com'),
(18, 'ganesh', 'Ganesh', 'ganesh@gmail.com'),
(19, 'gaurav', 'Gaurav', 'gaurav@yahoo.com'),
(20, 'gautam', 'Gautam', 'gautam@gmail.com'),
(21, 'kuldeep', 'Kuldeep', 'kuldeep@gmail.com'),
(22, 'mukesh', 'Mukesh', 'mukesh@yahoo.com'),
(23, 'nitin', 'Nitin', 'nitin@gmail.com'),
(24, 'palash', 'Palash', 'palash@gmail.com');