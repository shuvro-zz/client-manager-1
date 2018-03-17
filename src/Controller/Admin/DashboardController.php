<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class DashboardController extends AdminController
{
    /**
     * @Route("/dashboard", name="homepage")
     */
    public function dashboardAction()
    {
        $charts = $this->get('cm.chart_service');
        return $this->render(':default:index.html.twig', [
            'projects' => $this->getDoctrine()->getRepository('AppBundle:Project')->findCurrentProjects(),
            'invoices' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findBy([], ['createdAt' => 'DESC'], 10),
            'charts' => [
                'summary' => $charts->summaryChart(),
            ],
            'sum' => [
                'month' => [
                    'paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentMonth(true),
                    'not_paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentMonth(false),
                ],
                'year' => [
                    'paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentYear(true),
                    'not_paid' => $this->getDoctrine()->getRepository('AppBundle:Invoice')->findCurrentYear(false),
                ],
            ]
        ]);
    }
}
