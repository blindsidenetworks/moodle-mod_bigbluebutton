<?php 

/*
   Copyright 2010 Blindside Networks Inc.

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

  Initial version:
        Fred Dixon (ffdixon [at] blindsidenetworks [dt] org)
 */

    //This php script contains all the stuff to backup/restore
    //bigbluebuttonbn mods

    //This is the "graphical" structure of the BigBlueButton mod:
    //
    //                       bigbluebuttonbn
    //                     (CL,pk->id)
    //
    // Meaning: pk->primary key field of the table
    //          fk->foreign key to link with parent
    //          nt->nested field (recursive data)
    //          CL->course level info
    //          UL->user level info
    //          files->table may have files)
    //
    //-----------------------------------------------------------

    //This function executes all the backup procedure about this mod
    function bigbluebuttonbn_backup_mods($bf,$preferences) {
        global $CFG;

        $status = true; 

        ////Iterate over bigbluebuttonbn table
        if ($bigbluebuttonbns = get_records ("bigbluebuttonbn","course", $preferences->backup_course,"id")) {
            foreach ($bigbluebuttonbns as $bigbluebuttonbn) {
                if (backup_mod_selected($preferences,'bigbluebuttonbn',$bigbluebuttonbn->id)) {
                    $status = bigbluebuttonbn_backup_one_mod($bf,$preferences,$bigbluebuttonbn);
                }
            }
        }
        return $status;
    }
   
    function bigbluebuttonbn_backup_one_mod($bf,$preferences,$bigbluebuttonbn) {

        global $CFG;
    
        if (is_numeric($bigbluebuttonbn)) {
            $bigbluebuttonbn = get_record('bigbluebuttonbn','id',$bigbluebuttonbn);
        }
    
        $status = true;

        //Start mod
        fwrite ($bf,start_tag("MOD",3,true));
        //Print assignment data
        fwrite ($bf,full_tag("ID",4,false,$bigbluebuttonbn->id));
        fwrite ($bf,full_tag("MODTYPE",4,false,"bigbluebuttonbn"));
        fwrite ($bf,full_tag("NAME",4,false,$bigbluebuttonbn->name));
        fwrite ($bf,full_tag("MODERATORPASS",4,false,$bigbluebuttonbn->moderatorpass));
        fwrite ($bf,full_tag("VIEWERPASS",4,false,$bigbluebuttonbn->viewerpass));
        fwrite ($bf,full_tag("WAIT",4,false,$bigbluebuttonbn->wait));
        fwrite ($bf,full_tag("MEETINGID",4,false,$bigbluebuttonbn->meetingid));
        fwrite ($bf,full_tag("TIMEMODIFIED",4,false,$bigbluebuttonbn->timemodified));
        //End mod
        $status = fwrite ($bf,end_tag("MOD",3,true));

        return $status;
    }

    ////Return an array of info (name,value)
    function bigbluebuttonbn_check_backup_mods($course,$user_data=false,$backup_unique_code,$instances=null) {
        if (!empty($instances) && is_array($instances) && count($instances)) {
            $info = array();
            foreach ($instances as $id => $instance) {
                $info += bigbluebuttonbn_check_backup_mods_instances($instance,$backup_unique_code);
            }
            return $info;
        }
        
         //First the course data
         $info[0][0] = get_string("modulenameplural","bigbluebuttonbn");
         $info[0][1] = count_records("bigbluebuttonbn", "course", "$course");
         return $info;
    } 

    ////Return an array of info (name,value)
    function bigbluebuttonbn_check_backup_mods_instances($instance,$backup_unique_code) {
         //First the course data
        $info[$instance->id.'0'][0] = '<b>'.$instance->name.'</b>';
        $info[$instance->id.'0'][1] = '';
        return $info;
    }

?>
