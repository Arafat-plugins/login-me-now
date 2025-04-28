import React, { useState, useEffect } from 'react';
import { Layout, Form, Input, Button, Select, Space, message, Upload, InputNumber, Checkbox, Switch } from 'antd';
import { UploadOutlined } from '@ant-design/icons';
import { __ } from '@wordpress/i18n';
import postData from '@helpers/postData';

message.config({
  top: '90vh',
});

const { Sider, Content } = Layout;
const { TextArea } = Input;

export default function Settings() {
  const [fields, setFields] = useState([]);
  const [loading, setLoading] = useState(true);
  const [form] = Form.useForm();
  const [activeTab, setActiveTab] = useState('google');

  useEffect(() => {
    setLoading(true);
    postData('login-me-now/admin/settings/fields')
      .then((data) => {
        setFields(data);
        const formData = data.reduce((acc, field) => {
          acc[field.id] = field.previous_data ?? (field.type === 'checkbox' || field.type === 'switch' ? false : '');
          return acc;
        }, {});
        form.setFieldsValue(formData);
      })
      .catch((error) => {
        message.error(__('Failed to load settings fields.', 'content-restriction'));
        console.error(error);
      })
      .finally(() => {
        setLoading(false);
      });
  }, [form]);

  const tabs = [
    { key: 'wp-admin', label: __('/wp-admin', 'content-restriction'), section: 'general' },
    
    { key: 'google', label: __('Google', 'content-restriction'), section: 'logins' },
    { key: 'facebook', label: __('Facebook', 'content-restriction'), section: 'logins' },
    { key: 'email-magic-link', label: __('Email Magic Link', 'content-restriction'), section: 'logins' },
    { key: 'phone-otp', label: __('Phone OTP', 'content-restriction'), section: 'logins', is_upcoming: true },
    // { key: 'twitter-x', label: __('X(Twitter)', 'content-restriction'), section: 'logins', is_upcoming: true },
    

    { key: 'woocommerce', label: __('WooCommerce', 'content-restriction'), section: 'integrations' },
    { key: 'directorist', label: __('Directorist', 'content-restriction'), section: 'integrations' },
    { key: 'easy-digital-downloads', label: __('Easy Digital Downloads', 'content-restriction'), section: 'integrations' },
    { key: 'fluent-support', label: __('Fluent Support', 'content-restriction'), section: 'integrations', is_upcoming: true  },

    { key: 'custom-support', label: __('Customer Support', 'content-restriction'), section: 'more' },
    { key: 'license', label: __('License', 'content-restriction'), section: 'more' },
    // { key: 'custom-request', label: __('Custom Request', 'content-restriction'), section: 'more', is_upcoming: true  },
    // { key: 'enterprise-features', label: __('Enterprise Features', 'content-restriction'), section: 'more', is_upcoming: true },
  ];

  const sections = [
    { key: 'general', label: __('General', 'content-restriction') },
    { key: 'logins', label: __('Logins', 'content-restriction') },
    { key: 'integrations', label: __('Integrations', 'content-restriction') },
    { key: 'more', label: __('More', 'content-restriction') },
  ]

  const [forceUpdate, setForceUpdate] = useState(false);

  
  const renderField = (field) => {
    if (field.tab !== activeTab) return null;
  
    if (field.if_has && Array.isArray(field.if_has)) {
      const hasAllRequiredFields = field.if_has.every((requiredField) => {
        const currentValue = form.getFieldValue(requiredField);
        return !!currentValue; // must be truthy
      });
    
      if (!hasAllRequiredFields) {
        return null; // Hide the field if any required field is missing
      }
    }    

    const commonProps = {
      name: field.id,
      rules: [
        { required: field.required, message: `${field.title} is required.` },
        field.type === 'email' && { type: 'email', message: __('Invalid email format.', 'content-restriction') },
      ].filter(Boolean),
    };
  
    switch (field.type) {
      case 'text':
      case 'email':
        return (
          <Form.Item key={field.id} {...commonProps} className={field.class}>
            <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
            <span className="text-sm text-gray-500">{field.description}</span>
            <Input placeholder={field.placeholder} className="border rounded-lg px-3 py-2 block h-[50px] !p-3 !border-slate-200" />
          </Form.Item>
        );
      case 'textarea':
        return (
          <Form.Item key={field.id} {...commonProps} tooltip={field.tooltip} className={field.class}>
             <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
             <span className="text-sm text-gray-500">{field.description}</span>
            <TextArea placeholder={field.placeholder} rows={4} className="block h-[50px] !p-3 !border-slate-200" />
          </Form.Item>
        );
      case 'color':
        return (
          <Form.Item key={field.id} {...commonProps} tooltip={field.tooltip} className={field.class}>
             <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
             <span className="text-sm text-gray-500">{field.description}</span>
            <Input type="color" className="w-16 h-10 border rounded-lg" />
          </Form.Item>
        );
      case 'file':
        return (
          <Form.Item key={field.id} {...commonProps} tooltip={field.tooltip} className={field.class}>
            <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
            <span className="text-sm text-gray-500">{field.description}</span>
            <Upload beforeUpload={() => false} maxCount={1}>
              <Button icon={<UploadOutlined />} className="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                {__('Upload File', 'content-restriction')}
              </Button>
            </Upload>
          </Form.Item>
        );
      case 'number':
        return (
          <Form.Item key={field.id} {...commonProps} tooltip={field.tooltip} className={field.class}>
            <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
            <span className="text-sm text-gray-500">{field.description}</span>
            <InputNumber placeholder={field.placeholder} className="w-full border rounded-lg px-3 py-2" />
          </Form.Item>
        );
      case 'checkbox':
        return (
          <Form.Item key={field.id} name={field.id} valuePropName="checked" className="flex items-center space-x-2" tooltip={field.tooltip}>
            <div>
              <Checkbox>{field.description}</Checkbox>
            </div>
          </Form.Item>
        );
        case 'switch':
          return (
            <div className='custom-checkbox-class flex items-center space-x-2'>

              <div>
                <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
                <span className="text-sm text-gray-500">{field.description}</span>
              </div>

              <Form.Item
                key={field.id}
                name={field.id}
                valuePropName="checked"
                initialValue={false}  // Ensure there's an initial value
                rules={[
                  { required: false, message: `${field.title} is required.` },
                ]}
                tooltip={field.tooltip}
                className={field.class}
              >
              <Switch />
              </Form.Item>
            </div>
          ); 
      case 'select':
        return (
          <Form.Item key={field.id} {...commonProps} tooltip={field.tooltip} className={field.class}>
             <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
             <span className="text-sm text-gray-500">{field.description}</span>

            <Select placeholder={field.placeholder} className="w-full">
              {field.options?.map((option) => (
                <Select.Option key={option.value} value={option.value}>
                  {option.label}
                </Select.Option>
              ))}
            </Select>
          </Form.Item>
        );
        case 'multi-select':
          return (
            <Form.Item key={field.id} {...commonProps} tooltip={field.tooltip} className={field.class}>
               <h3 className="form-field-item-heading  text-[18px] text-[#000000] tablet:w-full font-medium">{field.title}</h3>
               <span className="text-sm text-gray-500">{field.description}</span>
               
              <Select
                mode="multiple"
                placeholder={field.placeholder || __('Select multiple options', 'content-restriction')}
                className="w-full"
                options={field.options?.map(option => ({
                  label: option.label,
                  value: option.value,
                }))}
              />
            </Form.Item>
          );
      default:
        return null;
    }
  };
  

  const handleSave = (values) => {
    setLoading(true); // Show loading state
    postData('login-me-now/admin/settings/save', values)
      .then((response) => {
        if (response.success) {
          message.success(__('Settings saved successfully!', 'content-restriction'));
        } else {
          throw new Error(response.message || __('Failed to save settings.', 'content-restriction'));
        }
      })
      .catch((error) => {
        message.error(error.message || __('Failed to save settings.', 'content-restriction'));
        console.error('Save Settings Error:', error);
      })
      .finally(() => {
        setLoading(false); // Remove loading state
      });
  };
  

  return (
    <div className="max-w-3xl mx-auto px-6 lg:max-w-screen-2xl">
      <div className="mx-auto mt-10 mb-8 font-semibold text-2xl">
        Settings
      </div>

      <Layout className="mx-auto my-[2.43rem] bg-white rounded-md shadow overflow-hidden min-h-[36rem]">
        <Sider width={350} className="bg-gray-100 p-6">

          <ul className="space-y-4">
            {sections.map((section) => {
              const sectionTabs = tabs.filter((tab) => tab.section === section.key);

              if (sectionTabs.length === 0) {
                return null; // Skip rendering if no tabs under this section
              }

              return (
                <li key={section.key}>
                  <div className="text-gray-500 uppercase text-xs font-semibold mb-2">{section.label}</div>
                  <ul className="space-y-2">
                  {sectionTabs.map((tab) => (
                    <li
                      key={tab.key}
                      className={`p-2 rounded-lg cursor-pointer flex items-center justify-between hover:bg-blue-100 hover:text-blue-700 text-white ${
                        tab.is_upcoming ? 'opacity-50 cursor-not-allowed' : (activeTab === tab.key ? 'bg-blue-500' : 'hover:bg-gray-200 text-black')
                      }`}
                      onClick={() => {
                        if (!tab.is_upcoming) {
                          setActiveTab(tab.key);
                        }
                      }}
                      title={tab.is_upcoming ? 'Coming Soon' : ''}
                    >
                      <span>{tab.label}</span>
                      {tab.is_upcoming && (
                        <span className="bg-yellow-300 text-yellow-900 text-xs font-semibold px-2 py-0.5 rounded-md ml-2">
                          Upcoming
                        </span>
                      )}
                    </li>
                  ))}

                  </ul>
                </li>
              );
            })}
          </ul>

        </Sider>

        <Content className="p-10 w-full">
          {activeTab && (
            
            <h2 className="text-2xl font-bold mb-6">
              {tabs.find(tab => tab.key === activeTab)?.label}
            </h2>
          )}
          <Form 
          form={form} 
          layout="vertical" 
          onFinish={handleSave} 
          disabled={loading}
          onValuesChange={() => {
            setForceUpdate(x => !x);
          }}
          >
            <div className="grid grid-cols-1 gap-0">
              {fields.map((field) => renderField(field))}
            </div>
            <Form.Item className="mt-6">
              <Space>
                <Button type="primary" htmlType="submit" className="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg disabled:opacity-50">
                  {__('Save Settings', 'content-restriction')}
                </Button>
              </Space>
            </Form.Item>
          </Form>
        </Content>

      </Layout>
    </div>
  );
}