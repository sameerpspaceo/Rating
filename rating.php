<?php
include_once 'connection.php';

if(!empty($_POST['points'])){
    $post_id = $_POST['post_id'];
    $rating_default_number = 1;
    $points = $_POST['points'];
    
    //Check the rating row with same post ID
    $prevRatingQuery = "SELECT * FROM view_rating WHERE post_id = ".$post_id;
    $prevRatingResult = $db->query($prevRatingQuery);
    if($prevRatingResult->num_rows > 0):
        $prevRatingRow = $prevRatingResult->fetch_assoc();
        $rating_default_number = $prevRatingRow['rating_number'] + $rating_default_number;
        $points = $prevRatingRow['total_points'] + $points;
        //Update rating data into the database
        $query = "UPDATE view_rating SET rating_number = '".$rating_default_number."', total_points = '".$points."', modified = '".date("Y-m-d H:i:s")."' WHERE post_id = ".$post_id;
        $update = $db->query($query);
    else:
        //Insert rating data into the database
        $query = "INSERT INTO view_rating (post_id,rating_number,total_points,created,modified) VALUES(".$post_id.",'".$rating_default_number."','".$points."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
        $insert = $db->query($query);
    endif;
    
    //Fetch rating deatails from database
    $query2 = "SELECT rating_number, FORMAT((total_points / rating_number),1) as average_rating FROM view_rating WHERE post_id = ".$post_id." AND status = 1";
    
    $result = $db->query($query2);
    $ratingRow = $result->fetch_assoc();
    
    if($ratingRow){
        $ratingRow['status'] = 'ok';
    }else{
        $ratingRow['status'] = 'err';
    }
    
    //Return json formatted rating data
    echo json_encode($ratingRow);

}
?>