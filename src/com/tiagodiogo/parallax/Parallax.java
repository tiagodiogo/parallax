package com.tiagodiogo.parallax;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.sql.SQLException;
import java.util.List;

import org.eclipse.californium.core.CoapClient;
import org.eclipse.californium.core.CoapHandler;
import org.eclipse.californium.core.CoapObserveRelation;
import org.eclipse.californium.core.CoapResponse;

import com.tiagodiogo.beans.NodeBean;
import com.tiagodiogo.utils.BorderRouterCrawler;
import com.tiagodiogo.utils.DatabaseUtils;

public class Parallax {
	
	private final String PROTOCOL = "coap";
	private final int PORT = 5683;
	
	private DatabaseUtils dbutils;
	
	public Parallax() throws ClassNotFoundException, IOException{
		dbutils = new DatabaseUtils();
	}
	
	private void processBorderRouter() throws IOException, NumberFormatException, SQLException{
		List<String> ips = BorderRouterCrawler.parse("http://[bbbb::100]/sensors.html");
		for(String ip : ips){
			CoapClient idFetcher = new CoapClient(PROTOCOL, "["+ip+"]", PORT, "info", "id");
			CoapResponse response = idFetcher.get();
			String keyCode = response.getResponseText();
			dbutils.setIP(Long.parseLong(keyCode), ip);
		}
		System.out.println("[BR-PARSER] - Parsing Completed");
	}
	
	private void observeNodes() throws SQLException{
		List<NodeBean> nodes = dbutils.getNodes();
		for(NodeBean node : nodes){
			if(node.getIp()!=null){
				CoapClient tempObserver = new CoapClient(PROTOCOL, "["+node.getIp()+"]", PORT, "sensors", "temperature");
				tempObserver.observe(
					new CoapHandler() {
						@Override public void onLoad(CoapResponse response) {
							String content = response.getResponseText();
							String[] output = response.advanced().getSource().getHostAddress().split(":");
							StringBuilder ipBuilder = new StringBuilder();
							for(int i = 0; i < output.length; i++){
								if(i != 1 && i != 2 && i != 3){
									ipBuilder.append(output[i]);
									if(i == 0){
										ipBuilder.append(":");
									}
									if(i != output.length-1){
										ipBuilder.append(":");
									}
								}
							}
							String ip = ipBuilder.toString();
							System.out.println("[NEW-TEMP] IP: " + ip + " | TEMP(mC):" + content);
							/*try {
								dbutils.setTemperature(ip,content);
							} catch (SQLException e) {
								System.out.println("error updating temperature on DB:");
								e.printStackTrace();
							}*/
						}
						
						@Override public void onError() {
							System.err.println("OBSERVING TEMP FAILED (press enter to exit)");
						}
					});
				CoapClient buttonObserver = new CoapClient(PROTOCOL, "["+node.getIp()+"]", PORT, "sensors", "button");
				buttonObserver.observe(
					new CoapHandler() {
						@Override public void onLoad(CoapResponse response) {
							String content = response.getResponseText();
							System.out.println("NOTIFICATION BUTTON: " + content);
						}
						
						@Override public void onError() {
							System.err.println("OBSERVING BUTTON FAILED (press enter to exit)");
						}
					});
			}
		}
	}
	
	public static void main(String [] args) throws IOException, ClassNotFoundException, NumberFormatException, SQLException
	{
		Parallax parallax = new Parallax();
		parallax.processBorderRouter();
		parallax.observeNodes();
		BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
		try { br.readLine(); } catch (IOException e) { }
		
	}
	
}
