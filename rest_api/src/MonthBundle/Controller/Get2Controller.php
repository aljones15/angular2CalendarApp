<?php

namespace MonthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use MonthBundle\Entity\Day;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Get2Controller extends Controller
{

    private function jsonResponse ($json)
    {
      $r = new JsonResponse($json);
      $r->headers->set('Access-Control-Allow-Origin', '*');
      $r->headers->set('Access-Control-Allow-Methods', 'PUT, GET, POST, OPTIONS');
      $r->headers->set('Access-Control-Allow-Headers', 'Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
      $r->headers->set('Content-Type', 'application/json');
      return $r;
    }

    private function jsonError(){
      $json_errors = array(
        JSON_ERROR_NONE => 'No error has occurred',
        JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
        JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
        JSON_ERROR_SYNTAX => 'Syntax error',
        );
        return $json_errors[json_last_error()];
    }

    private function removeBOM($data) {
      if (0 === strpos(bin2hex($data), 'efbbbf')) {
         return substr($data, 3);
      }
    }

    private function entityToJson($data){
      $encoders = array(new XmlEncoder(), new JsonEncoder());
      $normalizers = array(new ObjectNormalizer());
      $serializer = new Serializer($normalizers, $encoders);
      $json = $serializer->serialize($data, 'json');
      return $json;
    }

    private function createNewDay($em, $d){
      $day = new Day();
      $day->setDay(date_create($d['day']));
      $day->setSinglePrice($d['single']['price']);
      $day->setSingleAvailable($d['single']['available']);
      $day->setDoublePrice($d['double']['price']);
      $day->setDoubleAvailable($d['double']['available']);
      $em->persist($day);
      return $day;
    }

    /**
     * @Route("/month/{month_id}/year/{year_id}")
     * @Method({"OPTIONS"})
     */
    public function getMonth2OPTIONSAction($month_id, $year_id)
    {
      $resp = array("status" => "ok");
      return $this->jsonResponse($resp);
    }

    /**
     * @Route("/month/{month_id}/year/{year_id}")
     * @Method({"GET"})
     */
    public function getMonth2GetAction($month_id, $year_id)
    {
        $start = date_create('01-' . $month_id . '-' . $year_id);
        $end = date_create('01-' . $month_id . '-' . $year_id);
        if(!$start){
          return $this->jsonResponse(array('error' => 'invalid_date'));
        }
        $end = $end->modify('last day of this month');
        $repository = $this->getDoctrine()->getRepository('MonthBundle:Day');
        $qb = $repository->createQueryBuilder('d');
        $result = $qb->where('d.day BETWEEN :start AND :end')
          ->setParameter('start', $start->format('Y-m-d'))
          ->setParameter('end', $end->format('Y-m-d'))
          ->orderBy('d.day', 'ASC')->getQuery();
        $days = $result->getResult();
        $r = $this->jsonResponse($this->entityToJson($days));
        return $r;
    }

    /**
     * @Route("/createMonth")
     * @Method({"OPTIONS"})
     */
    public function postMonth2OPTIONSAction()
    {
      $resp = array("status" => "ok");
      return $this->jsonResponse($resp);
    }

    /**
     * @Route("/createMonth")
     * @Method({"POST"})
     */
    public function postMonth2CreateAction(Request $request)
    {
      $params = array();
      $result = array();
      $content = $request->getContent();
      if (!empty($content))
      {
          $params = json_decode($content , true);
          if(!$params){
            array_push($result, $this->jsonError());
            return $this->jsonResponse($result);
          }
          else {
            $em = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository('MonthBundle:Day');
            foreach($params as $d){
              $qb = $repository->createQueryBuilder('d');
              $start = date_create($d['day']);
              $query = $qb
                ->where('d.day = :start')
                ->setParameter('start', $start->format('Y-m-d'))
                ->orderBy('d.day', 'ASC')->getQuery();
              $days = $query->getResult();
              if(!$days){
                array_push($result, $this->createNewDay($em, $d));
              }
              else{
                foreach($days as $day){
                  $day->setSinglePrice($d['single']['price']);
                  $day->setSingleAvailable($d['single']['available']);
                  $day->setDoublePrice($d['double']['price']);
                  $day->setDoubleAvailable($d['double']['available']);
                  $em->persist($day);
                  array_push($result, $day);
                }
              }
            }
            $em->flush();
          }
      }
        if(count($result <= 0)){
          array_push($result, "no_days_added");
        }
        return $this->jsonResponse($this->entityToJson($result));
    }

    /**
     * @Route("/updateMonth")
     * @Method({"OPTIONS"})
     */
    public function putMonth2OPTIONSAction()
    {
      $resp = array("status" => "put_ok");
      $resp = $this->jsonResponse($resp);
      return $resp;
    }

    /**
     * @Route("/updateMonth")
     * @Method({"PUT"})
     */
    public function putMonth2UpdateAction(Request $request)
    {
      $params = array();
      $result = array();
      $content = $request->getContent();
      if (!empty($content))
      {
          $params = json_decode($content , true);
          $em = $this->getDoctrine()->getManager();
          $repository = $this->getDoctrine()->getRepository('MonthBundle:Day');
          $result = array();
          if(!$params){
            array_push($result, $this->jsonError());
            return $this->jsonResponse($result);
          }
          else {
            foreach($params as $d){
              if($d['id']){
                $day = $repository->find($d['id']);
                $day->setSinglePrice($d['single']['price']);
                $day->setSingleAvailable($d['single']['available']);
                $day->setDoublePrice($d['double']['price']);
                $day->setDoubleAvailable($d['double']['available']);
                $em->persist($day);
                array_push($result, $day);
              }
              $em->flush();
            }
          }
        }
        return $this->jsonResponse($this->entityToJson($result));
    }

}
