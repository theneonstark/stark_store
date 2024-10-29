-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 08:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `story` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `posted_by` int(11) NOT NULL,
  `blog_img` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `story`, `tags`, `posted_by`, `blog_img`, `created_at`, `updated_at`) VALUES
(4, 'From Vision to Virtual Shelves: Mohd Shahid’s Journey in Building Stark Store', 'In a world increasingly reliant on e-commerce, Mohd Shahid’s journey to founding Stark Store is a testament to the power of vision, perseverance, and innovation. The idea for Stark Store was born out of a simple observation: consumers were seeking a more personalized and convenient shopping experience online. Mohd, driven by his entrepreneurial spirit, recognized the potential to create a platform that not only offered a diverse range of products but also fostered a sense of community among shoppers.\\r\\n\\r\\nThe Spark of Inspiration\\r\\nMohd’s journey began while he was studying business management. He spent countless hours researching market trends, consumer behavior, and the evolving landscape of online shopping. Inspired by the stories of successful entrepreneurs, he envisioned a store that would not just be another e-commerce website but a unique destination that combined quality products with exceptional customer service.\\r\\n\\r\\nBuilding the Foundation\\r\\nWith a clear vision in mind, Mohd set out to build Stark Store from the ground up. He started by drafting a comprehensive business plan that outlined his goals, target market, and the core values that would define the store. After assembling a talented team of like-minded individuals—including a graphic designer and a product manager—Mohd began the challenging process of developing the website.\\r\\n\\r\\nEvery detail mattered, from the user interface to the product selection. Mohd’s team worked tirelessly to ensure that Stark Store would be visually appealing and user-friendly, creating an online space that invited customers to explore. They meticulously curated a wide range of products, focusing on quality and affordability, making sure to include items that resonated with their target audience.\\r\\n\\r\\nOvercoming Challenges\\r\\nThe path to launching Stark Store wasn’t without its hurdles. Mohd faced numerous challenges, from navigating the complexities of e-commerce logistics to ensuring that the website could handle high traffic volumes. However, his determination and adaptability allowed him to overcome these obstacles. He embraced feedback from early users, iterating on the platform to enhance the shopping experience continually.\\r\\n\\r\\nLaunching Stark Store\\r\\nAfter months of hard work, the day finally arrived for Stark Store to go live. Mohd and his team celebrated the launch, but they knew it was just the beginning. To create awareness and attract customers, Mohd implemented a robust marketing strategy that leveraged social media, influencer partnerships, and engaging content.\\r\\n\\r\\nThe response was overwhelmingly positive. Customers praised the store\\\'s intuitive design, extensive product range, and outstanding customer service. Mohd’s vision of a community-driven shopping experience was beginning to take shape.\\r\\n\\r\\nBuilding a Community\\r\\nAs Stark Store grew, Mohd focused on fostering a community around the brand. He engaged with customers through social media, soliciting their feedback and involving them in decisions about new product offerings. This two-way communication built trust and loyalty, turning one-time shoppers into repeat customers.\\r\\n\\r\\nMohd also initiated charitable campaigns, donating a portion of sales to local organizations, further solidifying Stark Store\\\'s commitment to giving back to the community. This approach resonated deeply with customers, who appreciated supporting a brand that shared their values.\\r\\n\\r\\nLooking Ahead\\r\\nToday, Stark Store stands as a successful e-commerce platform, driven by Mohd Shahid’s vision and dedication. With plans to expand the product range and enhance the shopping experience through innovative technologies, the journey is far from over. Mohd continues to dream big, envisioning Stark Store as a leader in the e-commerce space, known not just for its products but for its values and community spirit.\\r\\n\\r\\nIn reflecting on his journey, Mohd emphasizes the importance of perseverance and adaptability in entrepreneurship. “Every challenge is an opportunity to learn and grow,” he says, inspiring others to pursue their visions with passion and determination.\\r\\n\\r\\nConclusion\\r\\nFrom a simple idea to a thriving online store, Mohd Shahid’s journey in building Stark Store is a remarkable story of vision, hard work, and community spirit. As the e-commerce landscape continues to evolve, one thing is clear: Stark Store is here to stay, and its founder is just getting started.', '[\"Founder\",\"Admin\",\"Start Store\",\"Build\",\"Website\"]', 1, 'stark.jpg', '2024-10-29 19:29:52', '2024-10-29 19:29:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posted_by` (`posted_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posted_by` FOREIGN KEY (`posted_by`) REFERENCES `user`.`admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
