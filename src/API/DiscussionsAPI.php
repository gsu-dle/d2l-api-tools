<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\{
    Exception\D2LResponseException,
    Exception\D2LExpectedObjectException,
    Exception\D2LExpectedArrayException,
    Model\API\PagedResultSetModel,
    Model\API\RichTextInputModel
};


use InvalidArgumentException;

/**
 * D2L uses specific terms to refer to different parts of the Discussions area:
 * Forums are used to house discussion topics that are similar. For example, there might be several discussions in the first week of the course, so a forum titled "Week One Discussions" could contain those.
 * Topics are where the discussion actually takes place. This is where students can post threads in response to a discussion prompt.  
 * Threads are the initial comments added to a discussion topic. 
* Replies are responses posted to a specific discussion thread.
 * 
 * @package GAState\Tools\D2L\API
 * @access public
 * @see https://docs.valence.desire2learn.com/res/discuss.html#post--d2l-api-le-(version)-(orgUnitId)-discussions-forums-
 */

 class DiscussionsAPI extends D2LAPI
{
    /**
     * Retrieve a list of all discussion forums for an org unit.
     * 
     * @param int|null $orgUnitId Org ID
     * 
     * 
     * @return mixed
     * 
     * @see https://docs.valence.desire2learn.com/res/discuss.html#put--d2l-api-le-(version)-(orgUnitId)-discussions-forums-(forumId)
     * @see https://docs.valence.desire2learn.com/res/discuss.html#Discussions.Forum
     */
    public function getDisscusionForums(?int $orgUnitId = null)
    {
        if (
            $orgUnitId !== null 
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/discussions/forums/"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        return $response->data;
            
    }

    /**
     * This action returns a JSON array of Topic data blocks containing the properties for some topics in the indicated discussion forum.
     * 
     * @param int|null $orgUnitId Org ID
     * @param int|null $forumId Forum ID
     * 
     * @return mixed
     * 
     * @see https://docs.valence.desire2learn.com/res/discuss.html#put--d2l-api-le-(version)-(orgUnitId)-discussions-forums-(forumId)
     * @see https://docs.valence.desire2learn.com/res/discuss.html#Discussions.Forum
     */
    public function getDisscusionForum(?int $orgUnitId = null, ?int $forumId = null) {

        if (
            ($orgUnitId !== null) || ($forumId !== null)
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/discussions/forums/$forumId"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        return $response->data;


    }

    /**
     * Retrieve topics from the provided discussion forum in an org unit.
     * 
     * @param int|null $orgUnitId Org ID
     * @param int|null $forumId Forum ID
     * 
     * @return mixed
     * 
     * @see https://docs.valence.desire2learn.com/res/discuss.html#get--d2l-api-le-(version)-(orgUnitId)-discussions-forums-(forumId)-topics-
     * @see https://docs.valence.desire2learn.com/res/discuss.html#Discussions.Forum
     */
    public function getDisscusionForumTopics(?int $orgUnitId = null, ?int $forumId = null) {

        if (
            ($orgUnitId !== null) || ($forumId !== null)
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/discussions/forums/$forumId/topics/"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        return $response->data;


    }

   
     /**
     * Retrieve a particular topic from the provided discussion forum in an org unit.
     * 
     * @param int|null $orgUnitId Org ID
     * @param int|null $forumId Forum ID
     * @param int|null $topicId TopicId ID
     * 
     * @return mixed
     * 
     * @see https://docs.valence.desire2learn.com/res/discuss.html#get--d2l-api-le-(version)-(orgUnitId)-discussions-forums-(forumId)-topics-
     * @see https://docs.valence.desire2learn.com/res/discuss.html#Discussions.Forum
     */

    public function getDisscusionForumTopic(?int $orgUnitId = null, ?int $forumId = null, ?int $topicId = null) {

        if (
            ($orgUnitId !== null) || ($forumId !== null) || ($topicId !== null)
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/discussions/forums/$forumId/topics/$topicId"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        return $response->data;


    }


    /**
     * Retrieve all posts in a discussion forum topic.
     * 
     * @param int|null $orgUnitId Org ID
     * @param int|null $forumId Forum ID
     * @param int|null $topicId TopicId ID
     * 
     * @return mixed
     * 
     * @see https://docs.valence.desire2learn.com/res/discuss.html#get--d2l-api-le-(version)-(orgUnitId)-discussions-forums-(forumId)-topics-(topicId)-posts-
     * @see https://docs.valence.desire2learn.com/res/discuss.html#Discussions.Forum
     */
    public function getDisscusionForumTopicPosts(?int $orgUnitId = null, ?int $forumId = null, ?int $topicId = null) {

        if (
            ($orgUnitId !== null) || ($forumId !== null) || ($topicId !== null)
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/discussions/forums/$forumId/topics/$topicId/posts/"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        return $response->data;


    }

    /**
     * Retrieve a particular post in a discussion forum topic.
     * 
     * @param int|null $orgUnitId Org ID
     * @param int|null $forumId Forum ID
     * @param int|null $topicId Topic ID
     * @param int|null $postId Post Id 
     * 
     * @return mixed
     * 
     * @see https://docs.valence.desire2learn.com/res/discuss.html#get--d2l-api-le-(version)-(orgUnitId)-discussions-forums-(forumId)-topics-(topicId)-posts-
     * @see https://docs.valence.desire2learn.com/res/discuss.html#Discussions.Forum
     */
    public function getDisscusionForumTopicPost(?int $orgUnitId = null, ?int $forumId = null, ?int $topicId = null, ?int $postId = null) {

        if (
            ($orgUnitId !== null) || ($forumId !== null) || ($topicId !== null) || ($postId !== null)
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/discussions/forums/$forumId/topics/$topicId/posts/$postId"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        return $response->data;


    }

}