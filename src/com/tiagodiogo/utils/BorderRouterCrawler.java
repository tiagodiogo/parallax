package com.tiagodiogo.utils;

import java.io.IOException;
import java.util.HashMap;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

public class BorderRouterCrawler {

	public static HashMap<String, String> parse (String url) throws IOException{
		
		HashMap<String, String> nodes = new HashMap<String, String>();
		
		Document doc = Jsoup.connect(url).get();
		Elements rows = doc.select("tr");
		for (Element row : rows) {
		   Element node = row.select("td").get(0);
		   Element parent = row.select("td").get(4);
	
		   String nodeText = node.text();
		   String parentText = parent.text();
		   
		   //don't insert table header
		   if(!nodeText.equals("Node")){
			   nodes.put(nodeText, parentText);
		   }
		}
		
		return nodes;
	}
}
