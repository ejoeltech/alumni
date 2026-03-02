Dore Numa College Warri Alumni Portal

Project Awareness Document
Version 1.0
Founder: 1980 Alumni Initiative

1. Project Overview

The Dore Numa College Warri Alumni Portal is a web-based PHP application designed to serve as the digital hub for alumni engagement, communication, and project coordination.

The platform will:

Showcase past and upcoming events

Track alumni projects (Past, Running, Pending, Future)

Provide a secure user portal for members

Enable structured communication (SMS & WhatsApp)

Integrate AI features for automation and insights

Include administrative and developer management capabilities

The goal is to centralize alumni operations into one scalable, secure, and maintainable system.

2. Core Objectives

Improve alumni engagement and participation.

Centralize project and event visibility.

Enable structured member management.

Automate communication (announcements, birthdays, anniversaries).

Ensure scalability and maintainability.

Maintain data security and privacy compliance.

3. System Architecture
Technology Stack

Backend: PHP (OOP, MVC structure recommended)

Database: MySQL / MariaDB

Frontend: HTML5, CSS3, JavaScript

AI Integration: OpenAI API or equivalent

Messaging Integration:

SMS Gateway (e.g., Termii, Twilio, Africa’s Talking)

WhatsApp Business API

Hosting: VPS or shared hosting with SSL

Version Control: Git

4. Functional Requirements
4.1 Public Website Pages
Homepage

About the Alumni

Mission & Vision

Highlights

Call-to-Action (Join Now)

Events Page

Past Events

Upcoming Events

Event details (date, venue, description, media gallery)

Projects Page

Projects categorized as:

Past Projects

Running Projects

Pending Projects

Future Projects

Each project includes:

Title

Description

Budget (optional)

Status

Timeline

Supporting media

4.2 User Portal
Roles

Regular User

View events and projects

Update profile

Receive notifications

RSVP to events

Admin User

Manage events

Manage projects

Send announcements

View analytics

Manage users

Developer Manager (Super Admin)

System configuration

API key management

Messaging gateway configuration

Role management

Access logs

Database maintenance tools

4.3 Authentication System
Signup (Minimal & Simple)

Required Fields:

Full Name

Email

Phone Number

Set Password

Optional completion after signup:

Graduation Year

Department

Current Occupation

Location

Profile Photo

Bio

Email verification required.

4.4 AI Integration Features

AI can be used for:

Automated announcement drafting

Birthday/anniversary message personalization

Event summary generation

Project update summaries

Engagement insights

Smart reminders

Data analytics reports

AI usage must:

Log token usage

Limit request frequency

Protect member data privacy

4.5 Messaging System
SMS Features

Broadcast announcements

Birthday messages

Anniversary greetings

Event reminders

Emergency notifications

WhatsApp Integration

WhatsApp Business API integration

Sync with existing WhatsApp group (where permitted)

Broadcast structured messages

Template-based messaging

Automated greetings

Messaging rules:

Must respect opt-in/opt-out preferences

Log all sent messages

Rate-limit outgoing broadcasts

Admin approval required for bulk sends

4.6 Admin Dashboard

Features:

Event management (CRUD)

Project management (CRUD)

User management

Message broadcasting

Reports and analytics

Activity logs

Role assignment

4.7 Developer Manager Backend

Restricted to Super Admin.

Capabilities:

System configuration

Environment variable management

API key management

Messaging provider configuration

AI provider configuration

Backup & restore

Audit logs

Security monitoring

4.8 Settings & Management Page

Includes:

General settings (logo, name, contact info)

Notification settings

Message templates

Access control rules

Feature toggles

Maintenance mode

5. Non-Functional Requirements
Security

Password hashing (bcrypt or Argon2)

CSRF protection

XSS protection

SQL injection prevention (prepared statements)

Role-based access control (RBAC)

SSL enforcement

Audit logs

Performance

Optimized queries

Indexed database tables

Caching where applicable

Lazy loading for heavy content

Scalability

Modular architecture

API-ready backend

Decoupled messaging services

Environment-based configuration

Maintainability

MVC architecture

Code documentation

Version control

Environment separation (dev, staging, production)

6. Database Structure (High-Level)

Tables:

users

roles

events

projects

announcements

message_logs

ai_logs

settings

notifications

audit_logs

7. Governance Rules

No member data may be shared externally.

Only admins can send broadcast messages.

AI must not expose private member data.

System changes require developer manager approval.

All actions must be logged.

Member opt-out preferences must be respected.

Data backups must run weekly.

Production changes must be tested in staging first.

8. Deployment Rules

SSL must be active before launch.

Admin default passwords must be changed immediately.

API keys must not be hardcoded.

Database credentials must be stored in environment files.

Regular backups required.

Access to Developer Manager must be IP-restricted if possible.

9. Future Enhancements

Mobile App

Alumni Business Directory

Payment gateway for dues

Donation system

Ticketing system for events

Member-to-member messaging

Analytics dashboard

After the mvp lets phase it into 4 phases
Phase 1: Authentication + Events + Projects
Phase 2: Admin dashboard + Messaging
Phase 3: AI + Advanced analytics
Phase 4: Developer backend hardening