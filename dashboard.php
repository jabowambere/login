<?php
session_start();
$id=$_SESSION['id'];
if(!isset($id)){
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --secondary: #f43f5e;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --success: #10b981;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: grid;
            grid-template-columns: 240px 1fr;
            min-height: 100vh;
            background-color: #f1f5f9;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: white;
            box-shadow: 1px 0 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .logo img {
            width: 32px;
        }
        
        .logo h2 {
            font-size: 1.25rem;
            color: var(--dark);
        }
        
        .nav-menu {
            margin-top: 1.5rem;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .nav-item:hover {
            background-color: #f1f5f9;
            color: var(--primary);
        }
        
        .nav-item.active {
            background-color: #eef2ff;
            color: var(--primary);
            border-left: 3px solid var(--primary);
        }
        
        .nav-item i {
            width: 24px;
            text-align: center;
        }
        
        /* Main Content Styles */
        .main-content {
            padding: 1.5rem;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        
        .search-bar input {
            border: none;
            outline: none;
            padding: 0.5rem;
            width: 100%;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* Logout Button */
        .logout {
            background-color: var(--secondary);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logout:hover {
            background-color: #e11d48;
            transform: translateY(-1px);
        }
        
        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .card-icon.blue {
            background-color: var(--primary);
        }
        
        .card-icon.red {
            background-color: var(--secondary);
        }
        
        .card-icon.green {
            background-color: var(--success);
        }
        
        .card-icon.purple {
            background-color: #8b5cf6;
        }
        
        .card h3 {
            font-size: 0.875rem;
            color: var(--gray);
            font-weight: 500;
        }
        
        .card h2 {
            font-size: 1.5rem;
            color: var(--dark);
            margin-top: 0.25rem;
        }
        
        /* Charts Section */
        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .chart-container {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .chart-header h2 {
            font-size: 1.25rem;
            color: var(--dark);
        }
        
        /* Recent Orders */
        .recent-orders {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        th {
            color: var(--gray);
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        td {
            color: var(--dark);
        }
        
        .status {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status.completed {
            background-color: #dcfce7;
            color: #16a34a;
        }
        
        .status.pending {
            background-color: #fef9c3;
            color: #ca8a04;
        }
        
        .status.failed {
            background-color: #fee2e2;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <img src="https://via.placeholder.com/32" alt="Logo">
            <h2>Dashboard</h2>
        </div>
        
        <nav class="nav-menu">
            <a href="#" class="nav-item active">
                <i>📊</i> Dashboard
            </a>
            <a href="#" class="nav-item">
                <i>👥</i> Users
            </a>
            <a href="#" class="nav-item">
                <i>📦</i> Products
            </a>
            <a href="#" class="nav-item">
                <i>💰</i> Sales
            </a>
            <a href="#" class="nav-item">
                <i>📝</i> Reports
            </a>
            <a href="#" class="nav-item">
                <i>⚙️</i> Settings
            </a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <div class="search-bar">
                <i>🔍</i>
                <input type="text" placeholder="Search...">
            </div>
            
            <div class="user-menu">
                <i>🔔</i>
                <div class="user-avatar">JD</div>
                <a href="logout.php"><button name="logout" class="logout">🚪 Logout</button></a>
            </div>
        </header>
        
        <!-- Dashboard Cards -->
        <section class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <h3>Total Revenue</h3>
                </div>
                <h2>$24,780</h2>
                <div class="card-icon blue">
                    <i>💰</i>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Total Users</h3>
                </div>
                <h2>1,254</h2>
                <div class="card-icon red">
                    <i>👥</i>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Total Products</h3>
                </div>
                <h2>856</h2>
                <div class="card-icon green">
                    <i>📦</i>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Total Orders</h3>
                </div>
                <h2>3,240</h2>
                <div class="card-icon purple">
                    <i>🛒</i>
                </div>
            </div>
        </section>
        
        <!-- Charts Section -->
        <section class="charts">
            <div class="chart-container">
                <div class="chart-header">
                    <h2>Sales Overview</h2>
                    <select>
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last Year</option>
                    </select>
                </div>
                <div style="height: 300px; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: var(--gray);">
                    [Sales Chart Placeholder]
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h2>Revenue Sources</h2>
                </div>
                <div style="height: 300px; background: #f8fafc; display: flex; align-items: center; justify-content: center; color: var(--gray);">
                    [Pie Chart Placeholder]
                </div>
            </div>
        </section>
        
        <!-- Recent Orders -->
        <section class="recent-orders">
            <div class="chart-header">
                <h2>Recent Orders</h2>
                <button>View All</button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#ORD-0001</td>
                        <td>John Doe</td>
                        <td>2023-05-15</td>
                        <td>$125.00</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                    <tr>
                        <td>#ORD-0002</td>
                        <td>Jane Smith</td>
                        <td>2023-05-14</td>
                        <td>$89.50</td>
                        <td><span class="status pending">Pending</span></td>
                    </tr>
                    <tr>
                        <td>#ORD-0003</td>
                        <td>Robert Johnson</td>
                        <td>2023-05-13</td>
                        <td>$234.00</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                    <tr>
                        <td>#ORD-0004</td>
                        <td>Emily Davis</td>
                        <td>2023-05-12</td>
                        <td>$156.75</td>
                        <td><span class="status failed">Failed</span></td>
                    </tr>
                    <tr>
                        <td>#ORD-0005</td>
                        <td>Michael Wilson</td>
                        <td>2023-05-11</td>
                        <td>$342.60</td>
                        <td><span class="status completed">Completed</span></td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
