package com.tiagodiogo.main;

import org.eclipse.californium.core.CoapClient;

import com.tiagodiogo.examples.ClientExample;

public class Main {

	public static void main(String [] args)
	{
		//ClientExample.main(args);
		
		CoapClient client = new CoapClient("coap://californium.eclipse.org:5683/obs");
		String response = client.get().getResponseText();
		System.out.print(response);
		
		
	}
	
}
