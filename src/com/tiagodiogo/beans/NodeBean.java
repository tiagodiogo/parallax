package com.tiagodiogo.beans;

public class NodeBean {

	private int id;
	private String ip;

	public NodeBean(int id, String ip) {
		this.id = id;
		this.ip = ip;
	}

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public String getIp() {
		return ip;
	}

	public void setIp(String ip) {
		this.ip = ip;
	}
	
	

}
