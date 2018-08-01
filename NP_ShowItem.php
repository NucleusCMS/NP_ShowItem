<?php
class NP_ShowItem extends NucleusPlugin {
	function getName()          { return 'ShowItem'; }
	function getAuthor()        { return 'yama.kyms, sato(na)'; }
	function getURL()           { return 'http://wa.otesei.com/'; }
	function getVersion()       { return '0.4.2'; }
	function getDescription()   { return 'A specified item is displayed to skin.'; }
	function supportsFeature($w){ return ($w == 'SqlTablePrefix') ? 1 : 0; }
	function doSkinVar ($skinType, $template  = '', $itemid  = '')
	{
		global $blog, $manager;
		$itemid = intval($itemid);
		if (!isset($blog)) $blog = & $manager->getBlog(getBlogIDFromItemID($itemid));
		
		$query  = sprintf(
			"SELECT
				i.inumber   AS itemid,
				i.ititle    AS title,
				i.ibody     AS body,
				i.imore     AS more,
				i.icat      AS catid,
				i.itime,
				i.iclosed   AS closed,
				c.cname     AS category,
				m.mnumber   AS authorid,
				m.mname     AS author,
				m.mrealname AS authorname,
				m.memail    AS authormail,
				m.murl      AS authorurl
			FROM 
				%s AS i,
				%s AS c,
				%s AS m
			WHERE 
				    i.inumber=%u
				AND c.catid=i.icat
			limit 1"
			, mysql_real_escape_string(sql_table('item'))
			, mysql_real_escape_string(sql_table('category'))
			, mysql_real_escape_string(sql_table('member'))
			, intval($itemid) //ultrarich
		);
		$blog->showUsingQuery($template, $query, '', 1, 1);
	}
}
?>