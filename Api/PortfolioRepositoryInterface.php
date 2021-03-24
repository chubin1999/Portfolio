<?php
namespace AHT\Portfolio\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PortfolioRepositoryInterface
{
    /**
     * Save Post.
     *
     * @param \AHT\Portfolio\Api\Data\PortfolioInterface $post
     * 
     * @return \AHT\Portfolio\Api\Data\PortfolioInterface
     */
    public function save(\AHT\Portfolio\Api\Data\PortfolioInterface $post);

    /**
     * Get object by id
     *
     * @return \AHT\Portfolio\Api\Data\PortfolioInterface
     */
    public function getById(String $id);

    /**
     * Get All
     * 
     * @return \AHT\Portfolio\Api\Data\PortfolioInterface
     */
    public function getList();
    
    /**
     * Create post.
     *
     * @param \AHT\Portfolio\Api\Data\PortfolioInterface $post
     * 
     * @return \AHT\Portfolio\Api\Data\PortfolioInterface
     */
    public function createPost(\AHT\Portfolio\Api\Data\PortfolioInterface $post);

    /**
     * Update post
     *
     * @param String $id
     * @param \AHT\Blog\Api\Data\PostInterface $post
     * 
     * @return null
     */
    public function updatePost(String $id, \AHT\Portfolio\Api\Data\PortfolioInterface $post);

    /**
     * Delete Post by ID.
     *
     * @param string $postId
     * @return \AHT\Portfolio\Api\Data\PortfolioInterface
     */
    public function deleteById($postId);

}