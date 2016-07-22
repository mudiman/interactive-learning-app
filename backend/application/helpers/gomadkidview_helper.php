<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('templateView')) {

    
    function generate_bootstrap_dropdowns($label,$options){
        $dropdowns="";
        foreach($options as $option){
            $link=$option["link"];
            $title=$option["name"];
            $dropdowns.=<<<EOF
                          <li>
                            <a href="<?php echo base_url('$link');?>">$title</a>
                         </li>
EOF;
        }
        
        $htmlstr = <<<EOF
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">$label <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        $dropdowns
                    </ul>
                </li>
EOF;
        return $htmlstr;
    }
    
    function generate_message_view($status,$message){
        $CI =& get_instance();
        
        $data['status'] = $status;
        $data['message'] = $message."  ".anchor("page/managepage","Go back");
        $data['content'] = "messageview";
        $CI -> load -> view('common/layout', $data);
    }

}
