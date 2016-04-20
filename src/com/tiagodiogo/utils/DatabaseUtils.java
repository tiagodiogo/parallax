package com.tiagodiogo.utils;

import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;

import com.tiagodiogo.beans.NodeBean;

public class DatabaseUtils {

	private Properties prop = new Properties();
	
	public DatabaseUtils() throws IOException, ClassNotFoundException{
		InputStream inputStream = new FileInputStream("database.properties");
		prop.load(inputStream);
		Class.forName(prop.getProperty("DRIVER"));
	}
	
	private Connection getConnection() throws SQLException{
		return DriverManager.getConnection(prop.getProperty("URL"),
				   prop.getProperty("USER"),
				   prop.getProperty("PASS"));
	}
	
	
	public void setIP(Long keycode, String ip) throws SQLException{
		Connection dbConnection = getConnection();
		PreparedStatement preparedStatement = null;
		String updateTableSQL = "UPDATE authorized_nodes SET ip = ? "
                + " WHERE keycode = ?";
		
		preparedStatement = dbConnection.prepareStatement(updateTableSQL);

		preparedStatement.setString(1, ip);
		preparedStatement.setLong(2, keycode);
		
		preparedStatement.executeUpdate();

		preparedStatement.close();
		dbConnection.close();
	}

	public List<NodeBean> getNodes() throws SQLException {
		List<NodeBean> nodes = new ArrayList<NodeBean>();
		Connection dbConnection = getConnection();
		String query = "SELECT id,ip FROM authorized_nodes";
		Statement st = dbConnection.createStatement();
	    ResultSet rs = st.executeQuery(query);
	    while (rs.next()){
	    	int id = rs.getInt("id");
	    	String ip = rs.getString("ip");
	        nodes.add(new NodeBean(id,ip));
	    }
	    dbConnection.close();
		return nodes;
	}
	
	public int getID(String ip) throws SQLException{
		Connection dbConnection = getConnection();
		PreparedStatement preparedStatement = null;
		String updateTableSQL = "SELECT id FROM authorized_nodes WHERE ip = ?";
		
		preparedStatement = dbConnection.prepareStatement(updateTableSQL);
		preparedStatement.setString(1, ip);
		ResultSet rs = preparedStatement.executeQuery();
		
		rs.next();
		int id = rs.getInt("id");
		
		preparedStatement.close();
		dbConnection.close();
		
		return id;
	}

	public void setTemperature(String ip, String content) throws SQLException {
		Connection dbConnection = getConnection();
		int id = getID(ip);
		
		PreparedStatement preparedStatement = null;
		String updateTableSQL = "UPDATE node_resources SET value = ? WHERE node = ? ";
		
		preparedStatement = dbConnection.prepareStatement(updateTableSQL);

		preparedStatement.setString(1, content);
		preparedStatement.setInt(2, id);
		
		preparedStatement.executeUpdate();

		preparedStatement.close();
		dbConnection.close();
		
	}
	
}
