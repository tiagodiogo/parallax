package com.tiagodiogo.main;

import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Map.Entry;

import org.eclipse.californium.core.CoapClient;

import com.tiagodiogo.examples.ClientExample;
import com.tiagodiogo.utils.BorderRouterCrawler;

public class Main {

	public static void main(String [] args) throws IOException
	{
	
		HashMap<String, String> nodes = BorderRouterCrawler.parse("http://www.tiagodiogo.com/iot/sensors.html");
		for(Entry<String, String> entry : nodes.entrySet()){
			System.out.println("Node: " + entry.getKey() + " -> Parent: " + entry.getValue());
		}
		
		/*CoapClient client = new CoapClient("coap://californium.eclipse.org:5683/obs");
		String response = client.get().getResponseText();
		System.out.print(response);*/
		
		
	}
	
}
