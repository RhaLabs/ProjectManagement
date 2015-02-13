<?php
namespace LimeTrail\Bundle\Provider;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class GridModelProvider
{
    protected $translator;

    protected $router;

  /**
   * @var string;
   */
  private $query;

  /**
   * @var array;
   */
  private $colModel;

  /**
   * @var array;
   */
  private $colNames;

   /**
    * Construct
    *
    * @param ContainerInterface $container
    * @param array $dataGridIds
    */
   public function __construct(TranslatorInterface $translator, RouterInterface $router)
   {
       $this->translator = $translator;
       $this->router = $router;
   }

    public function getQuery()
    {
        return $this->query;
    }

    public function getColModel()
    {
        return $this->colModel;
    }

    public function getColNames()
    {
        return $this->colNames;
    }

    protected function spacify($camel, $glue = ' ')
    {
        return preg_replace('~([a-z0-9])([A-Z])~', "$1$glue$2", $camel);
    }

    public function createModel($query)
    {
        $this->query = $query;
        $names = explode(', ', str_replace("\n", ' ', $this->query), -1);
        array_shift($names);

        $this->colNames = array();
        $this->colModel = array();
        foreach ($names as $name) {
            if (stripos($name, 'as') !== false) {
                $setAggregated = true;
            }

              //$basename is the portion of name defined after the entity identifier or alias
              //example: u.firstName or u.firstName AS Name
              //returns:   firstName or   Name
              if (stripos($name, ' as ') > 0) {
                  $basename = preg_replace('~(.*\s(?:as)\s)~i', '', trim($name));

                  $index = $basename;
              } else {
                  $basename = preg_replace('~\w+\.~i', '', trim($name));

                  $index = trim($name);
              }

            $prettyname = $this->spacify(ucfirst($basename));
            $this->colNames[] = $this->translator->trans($prettyname);

            $width = max(array_map('strlen', explode(' ', $prettyname))) * 12;

            switch ($prettyname) {
                case "Job Title":
                  $width = 170;
                  break;
                case "Last Name":
                  $width = 150;
                  break;
                case "Address":
                  $width = 200;
                  break;
                case "Job Role":
                  $width = 160;
                  break;
                case "City":
                  $width = 140;
                  break;
                case "Email":
                  $width = 190;
                  break;
                case "Project Name":
                  $width = 210;
                  break;
                case "Intersection":
                  $width = 300;
                  break;
                case "Ci Title":
                  $width = 420;
                  break;
                default:
                  $width = $width;
              }

            if (preg_match('~\w*(phone)~i', $basename) === 1) {
                $width = 100;
            }

            $m = array('name' => $basename, 'index' => $index, 'width' => $width,
                    'align' => 'left', 'sortable' => true, 'search' => true,);

            if (isset($setAggregated) && $setAggregated) {
                $m = array_merge($m, array('aggregated' => true));
            }

            if (preg_match('/(confidential|combo|manageSitesDifferent|accepted)/', $name) === 1) {
                $m = array_merge($m, array('width' => 50, 'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array(
                        'value' => array(
                            1 => 'enable',
                            0 => 'disabled',
                         ),
                     ), ));
            }

            switch ($prettyname) {
                case "Job Role":
                  $route = $this->router->generate('fetch_job_roles');
                  $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'select', 'editrules' => array('required' => true),
                    'editoptions' => array(
                      'dataUrl' => $route,
                      ),
                    )
                   );
                  break;
                case "Ci Changes":
                  $route = $this->router->generate('project_change');
                  $m = array_merge($m, array('align' => 'left',
                    'editable' => false,
                    'search' => false,
                    'formatter' => 'RESTfulLink', 'formatoptions' => array(
                      'url' => $route.'project/',
                      'displayname' => 'Ci Changes',
                    ),
                  ));
                  break;
                case "Is Changed":
                  $m = array_merge($m, array(
                    'hidden' => true,
                    'formatter' => 'rowColorFormatter',
                    'formatoptions' => array(
                        'new' => 'yellowgreen',
                        'changed' => 'gold', ),
                    )
                  );
                  break;
                case "Address":
                  $route = $this->router->generate('limetrail_company_offices');
                  $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'select', 'editrules' => array('required' => true),
                    'editoptions' => array(
                      'dataUrl' => $route,
                      ),
                    )
                   );
                  break;
                case "Chart Color":
                  $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'text',
                    'editoptions' => array(
                      'dataInit' => 'function (elem) { $(elem).spectrum({
                          color: "#ECC",
    showInput: true,
    className: "full-spectrum",
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    maxPaletteSize: 10,
    preferredFormat: "hex6",
    localStorageKey: "spectrum.demo",
    move: function (color) {

    },
    show: function () {
      $("a#sData").addClass("ui-state-disabled");
    },
    beforeShow: function () {

    },
    hide: function () {
      $("a#sData").removeClass("ui-state-disabled");
    },
    change: function () {

    },
    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
                        });
                      }',
                    ),
                  ));
                  break;
                case "Middle Name":
                case "Job Title":
                case "Project Number":
                case "Project Name":
                  $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'text', 'editrules' => array('required' => false),
                    )
                   );
                  break;
                case "Direct Phone":
                case "Mobile Phone":
                  $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'text', 'editrules' => array('required' => false),
                    )
                   );
                  break;
                case "First Name":
                case "Last Name":
                case "Company":
                  $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'text', 'editrules' => array('required' => true),
                    )
                   );
                  break;
                case "Email":
                  $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'text',
                    'editrules' => array(
                            'required' => true,
                            'email' => true,
                        ),
                    'formatter' => 'email',
                    )
                   );
                  break;
                case "Edit":
                  $m = array_merge($m, array('width' => 65,
                      'formatter' => 'RESTfulLink',
                      'formatoptions' => array('url' => 'edit/',
                      'displayname' => 'form edit', ),
                      )
                    );
                  break;
              }

            if (stripos($prettyname, 'Actual') !== false ||
                    strpos($prettyname, 'Projected') !== false ||
                    strpos($prettyname, 'Date') !== false) {
                $m = array_merge($m, array( 'width' => 70,
                    'align' => 'center', 'sortable' => true, 'search' => true, 'stype' => 'text',
                    'searchoptions' => array(
                      'sopt' => array('eq', 'ne', 'lt', 'le', 'gt', 'ge'),
                      'dataInit' => 'function (elem) {
                      $(elem).datepicker({
                          inline: true,
                          dateFormat: "yy-mm-dd"
                        });
                      }',
                    ),
                     'formatter' => 'dateFmatter',
                     'formatoptions' => array(
                          'srcformat' => 'ISO8601Long', 'newformat' => 'm/d/Y', ), )
                    );
            }

            if (stripos($prettyname, 'Shell Due') !== false) {
                $m = array_merge($m, array(
                     'formatter' => 'date',
                     'formatoptions' => array(
                          'srcformat' => 'ISO8601Long', 'newformat' => 'm/d/Y', ), )
                    );
            }

            if (stripos($prettyname, 'Project Dates') !== false) {
                $m = array_merge($m, array(
                        'align' => 'left',
                        'formatter' => 'dependentGridLink',
                        )
                       );
            }

            if (stripos($prettyname, 'city') !== false) {
                $m = array_merge($m, array(
                    'editable' => true, 'edittype' => 'select', 'editrules' => array('required' => true),
                    'editoptions' => array(
                      'dataUrl' => '../../trail/feature/getcities/',
                      ),
                    'formatter' => 'showlink', 'formatoptions' => array(
                      'baseLinkUrl' => '../../trail/feature/cityurl', ),
                )
                       );
            }

            if (stripos($prettyname, 'Job Role') !== false) {
                $m = array_merge($m, array(
                      'editable' => true, 'edittype' => 'select', 'editrules' => array('required' => true),
                      'editoptions' => array(
                        'dataUrl' => $this->router->generate("fetch_job_roles"),
                        ),
                      )
                    );
            }

            if (stripos($prettyname, 'state') !== false) {
                $m = array_merge($m, array(
                    'formatter' => 'showlink', 'formatoptions' => array(
                      'baseLinkUrl' => '../../trail/feature/stateurl', ),
                       )
                     );
            }

            if (stripos($prettyname, 'Store Number') !== false) {
                $m = array_merge($m, array('formatter' => 'RESTfulLink',
                      'formatoptions' => array('url' => '../../trail/projectinformation/'),
                      )
                     );
            }

            if (stripos($prettyname, 'Ci Number') !== false) {
                $m = array_merge($m, array('formatter' => 'RESTfulLink',
                      'formatoptions' => array('url' => '../../change/get/'),
                      )
                     );
            }

            if (preg_match('/(description)/', $name) === 1) {
                $m = array_merge($m, array('width' => 230));
            }

            if (stripos($prettyname, 'contacts') !== false) {
                $m = array_merge($m, array('align' => 'left',
                    'editable' => false,
                    'search' => false,
                    'formatter' => 'RESTfulLink', 'formatoptions' => array(
                      'url' => '../../trail/contacts/project/',
                      'displayname' => 'Contacts',
                    ),
                  ));
            }

            if (preg_match('/(otbPossDays)/', $name) === 1) {
                $m = array_merge($m, array('width' => 50,
                      'formatter' => 'integer',  'search' => true,
                      )
                    );
            }

            array_push($this->colModel, $m);
        }
    }
}
