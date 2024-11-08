<?php

class User{

    public function get_data($id){

        $query = "select * from users where userid = '$id' limit 1";

        $DB = new Database();
        $result = $DB->read($query);

        if($result){

            $row = $result[0];

            return $row;

        }
        else{
            return false;
        }

    }

    public function get_user($id){

        $query = "select * from users where userid = '$id' limit 1";

        $DB = new Database();
        $result = $DB->read($query);

        if($result){
            return $result[0];
        }
        else{
            return false;
        }

    }
    
    public function get_friends($id){

        $query = "select * from users where userid != '$id' ";

        $DB = new Database();
        $result = $DB->read($query);

        if($result){
            return $result;
        }
        else{
            return false;
        }

    }

    public function get_following($id, $type){

        $DB = new Database();
        $type = addslashes($type);

        if(is_numeric($id)){

            //get following infor
            $sql = "select following from likes where type = '$type' && contentid = '$id' limit 1";
            $result = $DB->read($sql);
            
            if(is_array($result)){

                $likes = json_decode($result[0]['following'], true);
                return $likes;

            }

        }

        return false;

    }

    public function follow_user($id, $type, $wenet_userid){

        $DB = new Database();

        //save
        $sql = "select following from likes where type = '$type' && contentid = '$wenet_userid' limit 1";
        $result = $DB->read($sql);

        

        if(is_array($result)){
            
            $likes = json_decode($result[0]['following'], true);
            

            if(empty($likes)){
                $likes = [];
            }
            
            $user_ids = array_column($likes, "userid");
            //echo "<pre>";
            //print_r($user_ids);
            //echo "</pre>";
            //die;

            if(!in_array($id, $user_ids)){

                $arr["userid"] = $id;
                $arr["date"] = date("Y-m-d H:i:s");

                $likes[] = $arr;
                $likes_string = json_encode($likes);

                $sql = "update likes set following = '$likes_string' where type = '$type' && contentid = '$wenet_userid' limit 1";
                $DB->save($sql);

            }
            else{

                $key = array_search($id, $user_ids);
                unset($likes[$key]);

                $likes_string = json_encode($likes);

                $sql = "update likes set following = '$likes_string' where type = '$type' && contentid = '$wenet_userid' limit 1";
                $DB->save($sql);

            }
                
        }
        else{

            $arr["userid"] = $id;
            $arr["date"] = date("Y-m-d H:i:s");

            $arr2[] = $arr;

            $following = json_encode($arr2);

            $sql = "insert into likes (type, contentid, following) values ('$type', '$wenet_userid', '$following')";
            $DB->save($sql);

        }

    }

}