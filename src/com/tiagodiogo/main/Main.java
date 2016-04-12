package com.tiagodiogo.main;

import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.HashMap;
import java.util.Map.Entry;
import java.util.Properties;
import java.io.InputStream;
import java.io.FileInputStream;

import org.eclipse.californium.core.CoapClient;

import com.tiagodiogo.utils.BorderRouterCrawler;

public class Main {

	public static void main(String [] args) throws IOException
	{
	
		HashMap<String, String> nodes = BorderRouterCrawler.parse("http://[bbbb::100]/sensors.html");
		String response = null;
		for(Entry<String, String> entry : nodes.entrySet()){
			System.out.println("Node: " + entry.getKey() + " -> Parent: " + entry.getValue());
			CoapClient client = new CoapClient("coap://["+entry.getKey()+"]:5683/cfg/stack/mac");
			response = client.get().getResponseText();
			System.out.print(response);
		}
		
		InputStream inputStream;
		Properties prop = new Properties();
	
		inputStream = new FileInputStream("database.properties");
		prop.load(inputStream);
   
		Connection dbConnection = null;
		
		try {
			Class.forName(prop.getProperty("DRIVER"));
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		}
		
		try {
			dbConnection = DriverManager.getConnection(prop.getProperty("URL"),
													   prop.getProperty("USER"),
													   prop.getProperty("PASS"));
		
		PreparedStatement preparedStatement = null;
		String updateTableSQL = "UPDATE authorized_nodes SET active = ? "
                + " WHERE name = ?";
		
		preparedStatement = dbConnection.prepareStatement(updateTableSQL);

		preparedStatement.setBoolean(1, true);
		preparedStatement.setString(2, response);
		
		preparedStatement.executeUpdate();

		preparedStatement.close();
		dbConnection.close();
		
		} catch (SQLException e) {
			e.printStackTrace();
		}
		
	}
	
}
