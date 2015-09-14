<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\CountryContextBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Phlexible\Bundle\GuiBundle\Response\ResultResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Data controller
 *
 * @author Stephan Wentz <sw@brainbits.net>
 * @Route("/countrycontext")
 * @Security("is_granted('ROLE_FOCAL_POINT')")
 */
class DataController extends Controller
{
    /**
     * Get action
     *
     * @param Request $request
     *
     * @return ResultResponse
     * @Route("/get", name="countrycontext_get")
     */
    public function getAction(Request $request)
    {
        $countryContextRepository = $this->getDoctrine()->getRepository('PhlexibleCountryContextBundle:CountryContext');

        $data = array();
        foreach ($countryContextRepository->findAll() as $countryContext) {
            $data[] = array(
                'id' => $countryContext->getId()
            );
        }

        return new ResultResponse(true, '', $data);
    }

    /**
     * Set action
     *
     * @param Request $request
     *
     * @return ResultResponse
     * @Route("/set", name="countrycontext_set")
     */
    public function setAction(Request $request)
    {
        $this->getDoctrine()->getRepository('PhlexibleCountryContextBundle:CountryContext');

        return new ResultResponse(true, 'Focal point saved.');
    }
}
