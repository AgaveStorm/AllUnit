<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="*[type='bool']">
        <xsl:param name="value"/>
        <input type="checkbox" name="{name}">
            <xsl:if test="$value = '1'">
                <xsl:attribute name="checked">checked</xsl:attribute>
            </xsl:if>
        </input>
    </xsl:template>
</xsl:stylesheet>
