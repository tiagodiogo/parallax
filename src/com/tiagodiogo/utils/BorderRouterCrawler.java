package com.tiagodiogo.utils;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

public class BorderRouterCrawler {

	public static List<String> parse (String url) throws IOException{
		
		List<String> nodes = new ArrayList<String>();
		
		Document doc = Jsoup.connect(url).get();
		Elements rows = doc.select("tr");
		for (Element row : rows) {
		   Element node = row.select("td").get(0);
		   String nodeText = node.text();
		   
		   //don't insert table header
		   if(!nodeText.equals("Node")){
			   nodes.add(nodeText);
		   }
		}
		
		return nodes;
	}
}
