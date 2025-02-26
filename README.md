# STOCKSYNC (Inventory and File Management Systemn) - PHP Language

## Overview
The **Inventory and File Management System** is a comprehensive web-based application designed to streamline inventory tracking, document management, and employee workflow processes. Built using **PHP, MySQL, JavaScript, CSS, HTML, and AJAX**, this system ensures efficient record-keeping, enhanced security, and structured user management. 

The system enables organizations to maintain an up-to-date record of inventory, track document movement within teams, and enforce role-based access control. With security measures such as **JWT tokens, cookies, and refresh tokens**, it provides a robust authentication mechanism to prevent unauthorized access.

## Features
### **1. Inventory Management**
- Create, update, and delete inventory items.
- Categorize inventory into distinct categories.
- Maintain stock levels and generate reports for auditing and tracking purposes.
- Provide insights into inventory usage and requirements.

### **2. File Management & Document Workflow**
- Create and store documents with **file name, barcode, and description**.
- Assign documents to employees and track progress.
- Implement a step-by-step workflow where documents are marked to the next registered employee.
- The **admin** has a full view of the document flow, tracking its location at any given time.

### **3. User & Employee Management**
- Add, update, delete, and manage employees.
- Check employee activity status (**Active / Inactive**).
- Assign roles and permissions for controlled access.
- Manage user profiles and allow updates to personal information.

### **4. Authentication & Security**
- Secure authentication using **JWT tokens**.
- Implement **cookies and refresh tokens** for session persistence.
- Encrypt passwords and secure API endpoints against unauthorized access.
- Ensure role-based access control (RBAC) for different user types (Admin, Employee, User).

### **5. Reporting & Analytics**
- Generate real-time reports for inventory management.
- Track file movement history with timestamps.
- Provide an overview of active and completed document workflows.
- Generate detailed logs for user activity and document modifications.

## Technologies Used
- **Backend:** PHP with MySQL for database management.
- **Frontend:** HTML, CSS, JavaScript, and AJAX for a dynamic user interface.
- **Database:** MySQL for structured storage and retrieval of inventory and file records.
- **Security Measures:** JWT tokens, cookies, and refresh tokens for authentication and session management.

## Future Enhancements
- Integrate an **AI chatbot** for real-time user assistance and automation.
- Implement **advanced analytics and dashboard visualizations** for better insights.
- Improve **UI/UX** for better accessibility and usability.
- Add support for **multi-language functionality**.
- Implement **automatic notifications and reminders** for pending tasks.

## Installation Guide
### **Prerequisites**
- PHP (latest stable version)
- MySQL or MariaDB
- Apache or Nginx Server
- Composer (for dependency management)

### **Installation Steps**
1. Clone the repository:
   ```sh
   git clone https://github.com/MZDev-Tech/inventory-file-management.git
   ```
6. Access the application via `http://localhost:8000`.

## Contribution Guidelines
We welcome contributions from the community! To contribute:
1. Fork the repository.
2. Create a new feature branch.
3. Commit your changes and push the branch.
4. Submit a pull request for review.

## License
This project is licensed under the MIT License.

---
**Author:** Maria Zareef  
**Status:** Currently in active development 🚀

