<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkSelectIdControl">
        <xsl:variable name="value" select="params/value"/>
        <select name="{params/name}">
            <xsl:for-each select="items/item">
                <option value="{id}">
                    <xsl:if test="$value = id">
                        <xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    <xsl:value-of select="title"/>
                </option>
            </xsl:for-each>
        </select>
    </xsl:template>
</xsl:stylesheet>
