<?php
namespace Home\Controller;
use Home\Model\MemberModel;
use Think\Controller;
use QL\QueryList;
header("content-type:text/html;charset=utf-8");
class IndexController extends Controller {
    //Excel导出
    public function index(){
        vendor('PHPExcel.PHPExcel');  //载入第三方Excel类
        vendor('PHPExcel.PHPExcel.IOFactory');
        $objPHPExcel=new \PHPExcel(); // \代表命名空间根节点
        //$objPHPExcel->getProperties()-> setTitle("export") -> setDescription("none");
        $objPHPExcel -> setActiveSheetIndex(0);  //选择第一个工作区
        // Fieldnamesinthefirstrow
        //要输出的表头
        $head=['客户姓名','客户性别','客户手机号','员工姓名','投资金额','投资编号','计划投资日期','结束日期','客户证件号码'];
        //需要输出的数据
        $arr=M('member');
        $sql="select m_name,crm_member.sex,crm_member.mobile,username,invest_money,invest_num,invest_time,end_time,card_number from crm_invest_apply INNER JOIN crm_member ON crm_invest_apply.mid=crm_member.mid inner join crm_user ON crm_invest_apply.rm_id=crm_user.uid";
        $data=$arr->query($sql);
        foreach($data as $k=>$v)
        {
            if($data[$k]['sex']==1)
            {
                $data[$k]['sex']='男';
            }elseif ($data[$k]['sex']==2){
                $data[$k]['sex']='女';
            }
            $data[$k]['invest_time']=date('Y-m-d H:i:s',$data[$k]['invest_time']);
            $data[$k]['end_time']=date('Y-m-d H:i:s',$data[$k]['end_time']);
        }

//        var_dump($data);exit;
        //把表头输出在第一行
        $col = 0;
        foreach($head as $field){
            $objPHPExcel-> getActiveSheet()->setCellValueByColumnAndRow($col, 1,$field);
            $col++;
        }
        //获取数组（数据库）的字段
        $fields=['m_name','sex','mobile','username','invest_money','invest_num','invest_time','end_time','card_number'];
        // Fetchingthetabledata
        $row = 2;
        foreach($data as $v) {
            $col = 0;
            foreach($fields as $field)
            {
                //先输出列
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$v[$field]);
                $col++;
            }
            $row++;
        }
        $objPHPExcel -> setActiveSheetIndex(0);
        //写入excel表格
        $objWriter = \PHPExcel_IOFactory :: createWriter($objPHPExcel, 'Excel5');
        // Sendingheaderstoforcetheusertodownloadthefile
        header('Content-Type:application/vnd.ms-excel');
        //header('Content-Disposition:attachment;filename="Products_' . date('dMy') . '.xls"');
        header('Content-Disposition:attachment;filename="' .date('mdHis') . '.xls"');
        header('Cache-Control:max-age=0');
        $objWriter -> save('php://output'); //输出表格
    }
    //文件压缩上传
    public function ups()
    {
    	$url="http://www.nenghb.com/Meiti/details?id=290";
    	$rules=array(
    		'title'=>array('.detail>h2','text'),
    		'date'=>array('.detailTime:eq(0)','text'),
    		'content'=>Array('.detailText','html')
    	);
        $data = QueryList::Query($url,$rules)->data;
        print_r($data);
    }
}