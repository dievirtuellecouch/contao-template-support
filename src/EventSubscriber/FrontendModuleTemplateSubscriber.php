<?php

namespace DVC\TemplateSupport\EventSubscriber;

use Contao\ModuleModel;
use Plenta\ContaoJobsBasic\Controller\Contao\FrontendModule\JobOfferReaderController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;

class FrontendModuleTemplateSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (\is_array($controller) && $controller[0] instanceof JobOfferReaderController) {
            $instance = $controller[0];

            $event->setController(static function (Request $request, ModuleModel $model, string $section, array $classes = null) use ($instance) {
                if (isset($model->type) && 'plenta_jobs_basic_offer_reader' === (string) $model->type) {
                    $customTpl = (string) ($model->customTpl ?? '');
                    if ('' === $customTpl || !str_contains($customTpl, '/')) {
                        $model->customTpl = 'frontend_module/plenta_jobs_basic_offer_reader';
                    }
                }

                return $instance($request, $model, $section, $classes);
            });

            return;
        }

        if (\is_object($controller) && $controller instanceof JobOfferReaderController) {
            $instance = $controller;

            $event->setController(static function (Request $request, ModuleModel $model, string $section, array $classes = null) use ($instance) {
                if (isset($model->type) && 'plenta_jobs_basic_offer_reader' === (string) $model->type) {
                    $customTpl = (string) ($model->customTpl ?? '');
                    if ('' === $customTpl || !str_contains($customTpl, '/')) {
                        $model->customTpl = 'frontend_module/plenta_jobs_basic_offer_reader';
                    }
                }

                return $instance($request, $model, $section, $classes);
            });
        }
    }
}
