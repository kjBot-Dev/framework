<?php
namespace kjBot\Framework\Event;

class EventFactory{

    public static function createEventFrom($obj){
        switch($obj->post_type){
            case 'message':
                switch($obj->message_type){
                    case 'private':
                        return new PrivateMessageEvent($obj);
                    case 'group':
                        return new GroupMessageEvent($obj);
                    case 'discuss':
                    default:
                        throw new \Exception("Won't support {$obj->message_event} event: ".\export($obj));
                }
            case 'notice':
                switch($obj->notice_type){
                    case 'group_upload':
                        return new GroupFileUploadEvent($obj);
                    case 'group_admin':
                        return new GroupAdminChangeEvent($obj);
                    case 'group_decrease':
                        return new GroupDecreaseEvent($obj);
                    case 'group_increase':
                        return new GroupIncreaseEvent($obj);
                    case 'friend_add':
                        return new NewFriendEvent($obj);
                    default:
                        throw new \Exception('Unknow notice event: '.\export($obj));
                }
            case 'request':
                switch($obj->request_type){
                    case 'friend':
                        return new FriendRequestEvent($obj);
                    case 'group':
                        switch($obj->sub_type){
                            case 'add':
                                return new JoinGroupEvent($obj);
                            case 'invite':
                                return new InvitedToGroupEvent($obj);
                            default:
                                throw new \Exception('Unknown group request event: '.\export($obj));
                        }
                    default:
                        throw new \Exception('Unknown request event: '.\export($obj));
                }
            case 'meta_event':
                switch($obj->meta_event_type){
                    case 'lifecycle':
                        return new MetaLifecycleEvent($obj);
                    case 'heartbeat':
                        return new MetaHeartbeatEvent($obj);
                    default:
                    throw new \Exception('Unknown meta event: '.\export($obj));
                }
            default:
                throw new \Exception("Event {$obj->post_type} undefined: ".\export($obj));
        }
    }

}