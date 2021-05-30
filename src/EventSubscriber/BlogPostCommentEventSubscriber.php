<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\Bridge\Doctrine\Orm\AbstractPaginator;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use ApiPlatform\Core\DataProvider\PaginatorInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\BlogPostComment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BlogPostCommentEventSubscriber implements EventSubscriberInterface
{
    public function processComment(ViewEvent $viewEvent)
    {
        $comment = $viewEvent->getControllerResult();
        $method = $viewEvent->getRequest()->getMethod();

        if(!($comment instanceof BlogPostComment || ($comment instanceof AbstractPaginator) && $comment->count() > 0 && $comment->getIterator()[0] instanceof BlogPostComment) || Request::METHOD_GET !== $method)
            return;

        $comments = [$comment];
        if(is_iterable($comments))
            $comments = $comment;

        $clientIp = $viewEvent->getRequest()->getClientIp();

        /**
         * @var $comment BlogPostComment
         */
        foreach ($comments as $comment)
        {
            $isEditable = $comment->getAuthorIp() === $clientIp;
            $comment->isEditable = $isEditable;
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['processComment', EventPriorities::PRE_SERIALIZE],
        ];
    }
}