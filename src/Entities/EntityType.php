<?php
declare(strict_types=1);

namespace AirSlate\ApiClient\Entities;

/**
 * Interface EntityType
 * @package AirSlate\ApiClient
 */
interface EntityType
{
    public const ADDON = 'addons';
    public const ADDON_SMS = 'addons_sms';
    public const ADDON_FILE = 'addon_files';
    public const ADDON_INTEGRATION = 'addon_integrations';
    public const APPLICATION_MESSAGE_BUS_EVENT = 'applications-message-bus-event';
    public const APPLICATION_CALLBACK = 'applications-callback';
    public const PACKET_SEND = 'packet_send';
    public const PACKET_REVISION = 'packet_revisions';
    public const PACKET_REVISION_DOCUMENT = 'packet_revision_documents';
    public const PACKET_REVISION_LINK = 'packet_revision_links';
    public const PACKET_ROLES = 'packet_roles';
    public const PERMISSION = 'permissions';
    public const DOCUMENT = 'documents';
    public const DOCUMENT_ATTACHMENT = 'document_attachments';
    public const DOCUMENT_PERMISSION = 'document_permissions';
    public const DOCUMENT_ROLE = 'document_roles';
    public const DICTIONARY = 'dictionary';
    public const FILE = 'files';
    public const FLOW_ROLE = 'flow_roles';
    public const FLOW_ROLE_DOCUMENT = 'flow_role_documents';
    public const FLOW_ROLE_FIELD = 'flow_role_fields';
    public const ORGANIZATION = 'organizations';
    public const ORGANIZATION_USER = 'organization_users';
    public const ORGANIZATION_ADDON = 'organization_addons';
    public const PACKET = 'packets';
    public const SLATE = 'slates';
    public const SLATE_ADDON = 'slate_addons';
    public const SLATE_ADDON_FILE = 'slate_addon_files';
    public const SLATE_LINKS = 'slate_links';
    public const SLATE_INVITE = 'slate_invites';
    public const SLATE_DOCUMENT = 'slate_documents';
    public const SLATE_COLLABORATOR = 'slate_collaborators';
    public const TEMPLATE = 'templates';
    public const TOKEN = 'tokens';
    public const USER = 'users';
    public const EXPORT = 'export';
    public const EVENT = 'events';
    public const INVITE_EMAIL_ADDITION = 'invite_email_additions';
    public const SLATE_ADDON_LOG = 'slate_addon_logs';
}
