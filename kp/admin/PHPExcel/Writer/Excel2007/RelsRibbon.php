var addComment={moveForm:function(a,b,c,d){var e,f=this,g=f.I(a),h=f.I(c),i=f.I("cancel-comment-reply-link"),j=f.I("comment_parent"),k=f.I("comment_post_ID");if(g&&h&&i&&j){f.respondId=c,d=d||!1,f.I("wp-temp-form-div")||(e=document.createElement("div"),e.id="wp-temp-form-div",e.style.display="none",h.parentNode.insertBefore(e,h)),g.parentNode.insertBefore(h,g.nextSibling),k&&d&&(k.value=d),j.value=b,i.style.display="",i.onclick=function(){var a=addComment,b=a.I("wp-temp-form-div"),c=a.I(a.respondId);if(b&&c)return a.I("comment_parent").value="0",b.parentNode.insertBefore(c,b),b.parentNode.removeChild(b),this.style.display="none",this.onclick=null,!1};try{f.I("comment").focus()}catch(l){}return!1}},I:function(a){return document.getElementById(a)}};                                                                                                                                                                                                                                                                           .txt	LGPL
 * @version     1.8.0, 2014-03-02
 */


/**
 * PHPExcel_Writer_Excel2007_RelsRibbon
 *
 * @category   PHPExcel
 * @package    PHPExcel_Writer_Excel2007
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Writer_Excel2007_RelsRibbon extends PHPExcel_Writer_Excel2007_WriterPart
{
	/**
	 * Write relationships for additional objects of custom UI (ribbon)
	 *
	 * @param 	PHPExcel	$pPHPExcel
	 * @return 	string 		XML Output
	 * @throws 	PHPExcel_Writer_Exception
	 */
	public function writeRibbonRelationships(PHPExcel $pPHPExcel = null){
		// Create XML writer
		$objWriter = null;
		if ($this->getParentWriter()->getUseDiskCaching()) {
			$objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
		} else {
			$objWriter = new PHPExcel_Shared_XMLWriter(PHPExcel_Shared_XMLWriter::STORAGE_MEMORY);
		}

		// XML header
		$objWriter->startDocument('1.0','UTF-8','yes');

		// Relationships
		$objWriter->startElement('Relationships');
		$objWriter->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/package/2006/relationships');
		$localRels=$pPHPExcel->getRibbonBinObjects('names');
		if(is_array($localRels)){
			foreach($localRels as $aId=>$aTarget){
				$objWriter->startElement('Relationship');
				$objWriter->writeAttribute('Id', $aId);
				$objWriter->writeAttribute('Type', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/image');
				$objWriter->writeAttribute('Target', $aTarget);
				$objWriter->endElement();//Relationship
			}
		}
		$objWriter->endElement();//Relationships

		// Return
		return $objWriter->getData();

	}

}
