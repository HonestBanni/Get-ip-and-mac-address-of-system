<?php


class Crud_methods extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

     public function upload($file_name)
    {
        $config = array(
            'upload_path'=> 'uploadImages/',
            'allowed_types'=>'jpg|jpeg|png|gif',
            'max_size'=>'10000000000'
        );

        $this->load->library('upload', $config);
        $this->upload->do_upload($file_name);
        $data=$this->upload->data();
        return $data;
    }



    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Upload Images ---------------------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->
    public function uploadDirectory($file_name,$dir)
    {
        $config = array(
            'upload_path'=> $dir.'/',
            'allowed_types'=>'jpg|jpeg|png|gif|mp4|3gp|flv|mp3|doc|docx|rar',
            'max_size'=>'900000000000'
        );

        $this->load->library('upload', $config);
        $this->upload->do_upload($file_name);
        $data=$this->upload->data();
        return $data;
    }
    
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Fetch All Records Table------------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->

    public function get_records($table)
    {
        $this->db->select('*')
                 ->from($table);
        $query = $this->db->get();
         return $query->result();
     
    }
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Get One Record with Where Condition---------------------------------------->
    //---------------------------------------------------------------------------------------------------------->

    public function get_row_where($table,$id)
    {
        $this->db->select('*')
            ->from($table)
            ->where($id);
        $query = $this->db->get();

            return $query->row();

    }

    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Get Records with Where Condition---------------------------------------->
    //---------------------------------------------------------------------------------------------------------->

    public function get_result_where($table,$id)
    {
        $this->db->select('*')
            ->from($table)
            ->where($id);
        $query = $this->db->get();
      
            return $query->result();
       
    }
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Insert Records---------------------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->     
    
    
    public function Insertrecord($table,$data)
    {
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }
    
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Get Video Records------------------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->     
    
    
    public function get_video_record(){
                $query = $this->db->SELECT('*')
                ->FROM('video')
                ->JOIN('ml_week','video.weekId=ml_week.id')
               ->GET();
      return $query->result();
    }
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Dropdown Menu ---------------------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->     
    public  function dropdown_wd_option($table, $option, $key, $value) 
	{
	//$this->db->select('comittee_reg_master.id, comittee_info.name')
        //->from('comittee_reg_master')
        //->join('comittee_info','comittee_info.id= comittee_reg_master.comittee_info_id');
        $this->db->select('*')
            ->from($table);
        $query = $this->db->get();
            if($query->num_rows() > 0) 
                {
                    $data['0'] = $option;
                    foreach($query->result() as $row) 
                    {
                    $data[$row->$key] = $row->$value;
                    }
                return $data;
		}
	}

  public function getAllEmail($table,$id)
    {
        $this->db->select('*')
            ->from($table)
                ->order_by('days','asc')
            ->where($id);
            $query = $this->db->get();
      
            return $query->result();
       
    }

    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Show All Record Of Service With Join Tables by Id----------------------->
    //---------------------------------------------------------------------------------------------------------->
    public function getServicesAllById($where)
    {
        //$this->db->SELECT('services.id,services.serviceName,services.status,servicestype.serviceTypeName,worktype.workName,comments')
        $this->db->SELECT('*')
            ->FROM('services')
            ->JOIN('servicestype','servicestype.serviceTypeId = services.FKserviceTypeId')
            ->JOIN('worktype','worktype.workId = services.FKworkId')
            ->JOIN('servicesattachments','servicesattachments.FKservicesId = services.servicesId')
            ->JOIN('attachments','attachments.attachmentid = servicesattachments.FKattachmentsId')
            ->JOIN('servicescomments','servicescomments.FKservicesId = services.servicesId')
            ->JOIN('comments','comments.commentId = servicescomments.FKcommentsId')
            ->WHERE($where)
        ;
        $query   = $this->db->get();

        return $query->row();

    }



    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Show All Record Of Service With Join Tables----------------------------->
    //---------------------------------------------------------------------------------------------------------->
    public function showProject()
    {
        //$this->db->SELECT('services.id,services.serviceName,services.status,servicestype.serviceTypeName,worktype.workName,comments')
        $this->db->SELECT('*')
            ->FROM('projects')
            ->JOIN('servicestype','servicestype.serviceTypeId = projects.FKserviceTypeId')
            ->JOIN('projectstatus','projectstatus.projectStatusId = projects.FKprojectStatus')
         //   ->JOIN('servicesattachments','servicesattachments.FKservicesId = services.servicesId')
         //   ->JOIN('attachments','attachments.attachmentid = servicesattachments.FKattachmentsId')

            ->JOIN('projectscomments','projectscomments.FKprojectsId = projects.projectId')
            ->JOIN('comments','comments.commentId = projectscomments.FKcommentsId')
        ;
        $query   = $this->db->get();

        return $query->result();

    }


    public function showProjectFront($where){

        $this->db->SELECT('*')
             ->FROM('projects')
            ->JOIN('servicestype','servicestype.serviceTypeId = projects.FKserviceTypeId')
            ->JOIN('projectstatus','projectstatus.projectStatusId = projects.FKprojectStatus')
            ->JOIN('projectattachments','projectattachments.FKprojectId =projects.projectId')
            ->JOIN('attachments','attachments.attachmentId=projectattachments.PKattachmentsId')
            ->JOIN('projectscomments','projectscomments.FKprojectsId = projects.projectId')
            ->JOIN('comments','comments.commentId = projectscomments.FKcommentsId')
            ->GROUP_BY('projectId')
            ->WHERE($where)
        ;
        $query   = $this->db->get();

        return $query->result();

    }

    public function getImages($where)
    {
        $this->db->SELECT ('attachmentId,file')
                ->FROM('projectattachments')
                ->JOIN ('attachments','attachments.attachmentId = projectattachments.PKattachmentsId')
                ->WHERE($where)
        ;
        $query   = $this->db->get();

        return $query->result();

    }
    
      public function getImagesRow($where)
    {
        $this->db->SELECT ('*')
                ->FROM('projectattachments')
                ->JOIN ('attachments','attachments.attachmentId = projectattachments.PKattachmentsId')
                ->WHERE($where)
        ;
        $query   = $this->db->get();

        return $query->row();

    }
    
          public function getImagesS($where)
    {
        $this->db->SELECT ('*')
                ->FROM('projectattachments')
                ->JOIN ('attachments','attachments.attachmentId = projectattachments.PKattachmentsId')
                ->WHERE($where)
        ;
        $query   = $this->db->get();

        return $query->result();

    }
 public function getAllProjects($where){
     $query = $this->db->SELECT('*')
             ->FROM('projects P')
             ->JOIN('projectstatus PS','PS.projectStatusId=P.FKprojectStatus')
             ->JOIN('servicestype','servicestype.serviceTypeId=P.FKserviceTypeId')
             ->WHERE($where)
             ->GET();
     return $query->result();
 }
 
    public function getAllProject($where){
        $query = $this->db->SELECT('*')
                        ->FROM('projects p')
                        ->JOIN('servicestype s','s.serviceTypeId=p.FKserviceTypeId')
                        ->JOIN('projectstatus ps','ps.projectStatusId=p.FKprojectStatus')
                        ->JOIN('projectscomments pc','pc.FKprojectsId=p.projectId')
                        ->JOIN('comments c','c.commentId=pc.FKcommentsId')
                        ->WHERE($where)
                        ->GET();
        return $query->row();


    }


    public function ProjectImages($where)
    {
        $query = $this->db->SELECT('*')
            ->FROM('projects p')
            ->JOIN('projectattachments pa','pa.FKprojectId=p.projectId')
            ->JOIN('attachments a','a.attachmentId=pa.PKattachmentsId')

            ->WHERE($where)
            ->GET();
        return $query->result();

    }

    public function showDistributerAll( )
    {
        $query = $this->db->SELECT('*')
                        ->FROM('distributers D')
                        ->JOIN('distributerattachment DA','D.distributerId=DA.FKdistributerId')
                        ->JOIN('attachments A','A.attachmentId=DA.FKattachmentId')
                        ->JOIN('distributercomments DC','DC.FKdistributerId=DA.FKdistributerId')
                        ->JOIN('comments C','C.commentId=DC.FKcommentsId')

                        ->GET();
        return $query->result();
    }

    public function showDistributerAllFront($where =Null)
    {
        $query = $this->db->SELECT('*')
            ->FROM('distributers D')
            ->JOIN('distributerattachment DA','D.distributerId=DA.FKdistributerId')
            ->JOIN('attachments A','A.attachmentId=DA.FKattachmentId')
            ->JOIN('distributercomments DC','DC.FKdistributerId=DA.FKdistributerId')
            ->JOIN('comments C','C.commentId=DC.FKcommentsId')
            ->WHERE($where)
            ->GET();
        return $query->result();
    }
  public function distributerRow($where =Null)
    {
        $query = $this->db->SELECT('*')
            ->FROM('distributers D')
            ->JOIN('distributerattachment DA','D.distributerId=DA.FKdistributerId')
            ->JOIN('attachments A','A.attachmentId=DA.FKattachmentId')
            ->JOIN('distributercomments DC','DC.FKdistributerId=DA.FKdistributerId')
            ->JOIN('comments C','C.commentId=DC.FKcommentsId')
            ->WHERE($where)
            ->GET();
        return $query->row();
    }

    public function showAllClients()
    {
            $query = $this->db->SELECT('*')
                            ->FROM('clients C')
                            ->JOIN('clientscomments CC','CC.FKclientsId=C.clientId')
                            ->JOIN('comments CM','CM.commentId=CC.FKcommentsId')
                            ->JOIN('clientsattachments CA','CA.FKclientsId=C.clientId')
                            ->JOIN('attachments A','A.attachmentId =CA.FKattachmentID')
                            ->GET();
        return $query->result();
    }




    public function showAllClientsWhere()
    {
        $query = $this->db->SELECT('*')
            ->FROM('clients C')
            ->JOIN('clientscomments CC','CC.FKclientsId=C.clientId')
            ->JOIN('comments CM','CM.commentId=CC.FKcommentsId')
            ->JOIN('clientsattachments CA','CA.FKclientsId=C.clientId')
            ->JOIN('attachments A','A.attachmentId =CA.FKattachmentID')
            ->GET();
        return $query->result();
    }

    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Get One Record with Where Condition-------------------------------------->
    //---------------------------------------------------------------------------------------------------------->
    public function get_record_by_id($table,$where)
    {
        $this->db->select('*')
            ->from($table)
            ->where($where);
            $query = $this->db->get();
               // echo '<pre>';print_r($query);die;

                    return $query->row();


    }




    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Get One Record with Where Condition-------------------------------------->
    //---------------------------------------------------------------------------------------------------------->
    public function get_records_by_id($table,$where)
    {
        $this->db->select('*')
            ->from($table)
            ->where($where);
        $query = $this->db->get();
        // echo '<pre>';print_r($query);die;
        if($query->num_rows>0)
        {
            return $query->result();
        }

    }


    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Fetch attachment Name       -------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->

    public function get_attachment($where)
    {

       //$query =  $this->db->select('attachments.file, attachments .attachmentId')
        $query =  $this->db->select('*')
                ->from('services')
                ->JOIN('servicesattachments','`servicesattachments`.`FKservicesId`=services.servicesId')
                ->JOIN ('attachments','attachments.attachmentId=servicesattachments.FKattachmentsId')
                ->Where ($where)
                ->get();
        //echo '<pre>'; print_r($query);die;
        return $query->row();

    }

    //Send Copy

    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Fetch Services Mechanical       -------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->

    public function servicesmechanical($where)
    {

        //$query =  $this->db->select('attachments.file, attachments .attachmentId')
        $this->db->SELECT('*')
            ->FROM('services')
            ->JOIN('servicestype','servicestype.serviceTypeId = services.FKserviceTypeId')
            ->JOIN('worktype','worktype.workId = services.FKworkId')
            ->JOIN('servicesattachments','servicesattachments.FKservicesId = services.servicesId')
            ->JOIN('attachments','attachments.attachmentid = servicesattachments.FKattachmentsId')

            ->JOIN('servicescomments','servicescomments.FKservicesId = services.servicesId')
            ->JOIN('comments','comments.commentId = servicescomments.FKcommentsId')
            ->WHERE($where)
        ;
        $query   = $this->db->get();
         //echo '<pre>'; print_r($query);die;
        return $query->result();

    }



    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Update By ID------------------------------------------------------------>
    //---------------------------------------------------------------------------------------------------------->
    public function update($table,$data,$where)
    {
        $this->db->where($where);
        $this->db->update($table,$data);
    }
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Update By ID------------------------------------------------------------>
    //---------------------------------------------------------------------------------------------------------->
    public function Trashe($where,$data)
    {
        $this->db->where($where);
        $this->db->update('scheme',$data);
    }
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Delete By ID------------------------------------------------------------>
    //---------------------------------------------------------------------------------------------------------->
    public function deleteid($table,$whereid)
    {
        $this->db->where($whereid);
        $this->db->delete($table);
    }
 
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Upload Images ---------------------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->
   
    //---------------------------------------------------------------------------------------------------------->
    //----------------------------------Show showUser Record---------------------------------------------------------->
    //---------------------------------------------------------------------------------------------------------->
    public function showAllUser($where){
        $query = $this->db->SELECT('*')
                  ->FROM('user')
                    ->WHERE($where)
                ->GET();
        return $query->result();
    }
 
        
}