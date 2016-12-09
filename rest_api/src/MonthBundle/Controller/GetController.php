<?php

namespace MonthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GetController extends Controller
{
    /**
     * @Route("/month/year")
     */
    public function getMonthAction()
    {
        return $this->render('MonthBundle:Get:get_month.html.twig', array(
            // ...
        ));
    }

}
