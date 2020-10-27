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
    public const BRANCH = 'branches';
    public const PACKET_SEND = 'packet_send';
    public const PACKET_REVISION = 'packet_revisions';
    public const PACKET_REVISION_DOCUMENT = 'packet_revision_documents';
    public const PACKET_REVISION_LINK = 'packet_revision_links';
    public const PACKET_ROLES = 'packet_roles';
    public const PACKET_ROLE_DOCUMENT = 'packet_role_documents';
    public const PERMISSION = 'permissions';
    public const META_PERMISSION = 'meta_permissions';
    public const DOCUMENT = 'documents';
    public const DOCUMENT_ATTACHMENT = 'document_attachments';
    public const DOCUMENT_PERMISSION = 'document_permissions';
    public const EDITOR_OPTIONS = 'editor_options';
    public const ENVELOPE_SMS = 'envelope_sms';
    public const DOCUMENT_ROLE = 'document_roles';
    public const DICTIONARY = 'dictionary';
    public const EXPERIMENT = 'experiment';
    public const FILE = 'files';
    public const GUEST = 'guests';
    public const STORAGE_FILE = 'storage_files';
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
    public const LOOKUP_ORGANIZATION = 'lookup-organizations';
    public const SLATE_ADDON_INTEGRATION = 'slate_addon_integrations';
    public const PACKET_SIGNING_ORDER = 'packet_signing_order';
    public const FLOW_TAG = 'flow_tags';
    public const PLANS = 'plans';
    public const PARTICIPANT_ROLES = 'participant_roles';
    public const RESEND_PACKET_INVITE = 'resend_packet_invite';
    public const NOTIFICATION = 'notifications';
    public const PACKET_ROLES_ASSIGN = 'packet_roles_assign';
    public const CONTACT_GROUP = 'contact_groups';
    public const INTEGRATION_REQUESTS = 'integration_requests';
    public const RESOLVE_TAGS = 'resolve_tags';
}
