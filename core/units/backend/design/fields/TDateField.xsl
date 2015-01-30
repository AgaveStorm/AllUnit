<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="*[type='TDateField']">
        <xsl:param name="value"/>
        <input type="text"
               name="{name}"
               class="datepicker dateonly" 
               value="{$value}"/>
    </xsl:template>
</xsl:stylesheet>
