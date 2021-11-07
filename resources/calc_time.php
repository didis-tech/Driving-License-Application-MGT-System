<?php






// $hour = date("H");

// if($hour >= 20){

//   $greeting = "Good Night ". $name . "  , Have a good night rest.";

// }elseif ($hour > 17) {

//   $greeting = "Good Evening ". $name ." , Hope you enjoyed your day?";

// }elseif ($hour > 11) {

//   $greeting = "Good Afternoon ". $name . " , How is your day going?";

// }elseif ($hour < 12) {

//   $greeting = "Good Morning ". $name ." , How was your night?";

// }



function get_time_ago( $time )

{

    $time_difference = time() - $time;



    if( $time_difference < 1 ) { return 'less than 1 second ago'; }

    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',

                30 * 24 * 60 * 60       =>  'month',

                24 * 60 * 60            =>  'day',

                60 * 60                 =>  'hour',

                60                      =>  'minute',

                1                       =>  'second'

    );



    foreach( $condition as $secs => $str )

    {

        $d = $time_difference / $secs;



        if( $d >= 1 )

        {

            $t = round( $d );

            return ' ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';

        }

    }

}

        function getTheDay($date)

        {

            $curr_date=strtotime(date("Y-m-d H:i:s"));

            $the_date=strtotime($date);

            $diff=floor(($curr_date-$the_date)/(60*60*24));

            switch($diff)

            {

                case 0:

                    return "Today";

                    break;

                case 1:

                    return "Yesterday";

                    break;

                default:

                    return $diff." Days ago";

            }

        }



        function relative_date($time) {



        $today = strtotime(date('M j, Y'));



        $reldays = ($time - $today)/86400;



        if ($reldays >= 0 && $reldays < 1) {



        return 'Today';



        } else if ($reldays >= 1 && $reldays < 2) {



        return 'Tomorrow';



        } else if ($reldays >= -1 && $reldays < 0) {



        return 'Yesterday';



        }



        if (abs($reldays) < 7) {



        if ($reldays > 0) {



        $reldays = floor($reldays);



        return 'In ' . $reldays . ' day' . ($reldays != 1 ? 's' : '');



        } else {



        $reldays = abs(floor($reldays));



        return $reldays . ' day' . ($reldays != 1 ? 's' : '') . ' ago';



        }



        }



        if (abs($reldays) < 182) {



        return date('l, j F',$time ? $time : time());



        } else {



        return date('l, j F, Y',$time ? $time : time());



        }



        }



 ?>

